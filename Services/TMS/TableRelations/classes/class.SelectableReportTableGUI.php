<?php
require_once 'Services/Table/classes/class.ilTable2GUI.php';

use CaT\Libs\ExcelWrapper as ExcelWrapper;
use CaT\Libs\ExcelWrapper\Style as Style;
use CaT\Libs\ExcelWrapper\Spout\SpoutInterpreter as SI;
/**
 * Table with selectable columns for report taking care of requested fields
 */
class SelectableReportTableGUI extends ilTable2GUI {
	protected $persistent = [];
	protected $order = [];
	protected $selectable = [];
	protected $internal_sorting_columns = [];
	protected $export_writer = [];


	public function __construct($a_parent_gui, $a_cmd) {
		global $DIC;
		$g_ctrl = $DIC['ilCtrl'];
		$this->setId("elpt_".$a_parent_gui->id);
		parent::__construct($a_parent_gui, $a_cmd);
		$this->setEnableTitle(false);
		$this->setTopCommands(false);
		$this->setEnableHeader(true);
		$this->setFormAction($g_ctrl->getFormAction($a_parent_gui,$a_cmd));
		$this->columns_determined = false;
		$this->setExternalSorting(true);
		$this->export_formats = [];
	}

	/**
	 * Configure an export path via some ExcelWrapper\Writer
	 *
	 * @param	ExcelWrapper\Writer	$writer
	 * @param	int	$format_id
	 * @param	string	$export_format_title
	 * @param	string	$export_format_mine
	 * @return 	void
	 */
	public function addExporter(
		ExcelWrapper\Writer $writer,
		$format_id,
		$export_format_title,
		$export_format_mine)
	{
		assert('is_int($format_id)');
		assert('is_string($export_format_title)');
		assert('is_string($export_format_mine)');
		$this->export_formats[$format_id] = $export_format_title;
		$this->export_writer[$format_id] = $writer;
		$this->export_mime[$format_id] = $export_format_mine;
	}

	/**
	 * @inheritsdoc
	 */
	public function exportData($format_id, $send = false)
	{
		assert('is_int($format_id)');
		if($this->dataExists()) {
			if(!array_key_exists($format_id, $this->export_writer)) {
				throw new \InvalidArgumentException('unknown format');
			}
			$this->exportByFormat((int)$format_id, $send);
		}
	}

	/**
	 * Export data via an ExcelWrapper\Writer corresponding to $format_id
	 *
	 * @param	int	$format_id
	 * @param	bool	$send
	 */
	protected function exportByFormat($format_id, $send = false)
	{
		$si = new SI();
		$writer = $this->export_writer[$format_id];
		assert('is_int($format_id)');
		$path = rtrim(sys_get_temp_dir(),DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

		$writer->setPath($path);
		$filename = ltrim(str_replace($path,'',tempnam($path, 'xlsx_write')), DIRECTORY_SEPARATOR);
		$writer->setFileName($filename);
		$writer->openFile();
		$header_style = new Style();
		$header_style = $header_style->withBold(true);
		$data_style = new Style();
		$columns = $this->relevantColumns();
		$writer->setColumnStyle('A',$si->interpret($header_style));
		$header = [];

		foreach ($columns as $column_id => $metadata) {
			$header[] = $metadata['txt'];
		}
		$writer->addRow($header);
		$writer->setColumnStyle('A',$si->interpret($data_style));

		foreach ($this->row_data as $data_set) {
			$row = [];
			foreach ($columns as $column_id => $metadata) {
				$row[] = $data_set[$column_id];
			}
			$writer->addRow($row);
		}

		$writer->close();
		if($send) {

			\ilUtil::deliverFile(
				$path.DIRECTORY_SEPARATOR.$filename,
				'report',
				$this->export_mime[$format_id],
				false,
				true,
				true);
			exit();
		}

	}

	/**
	 * Define a column depending on one or several fields. I.e. fields are requested if column is activated.
	 *
	 * @param	string	$title 
	 * @param	string	$column_id
	 * @param	AbstractField[field_id]	$fields 
	 * @param	bool	$selectable 
	 * @param 	bool	$sort 
	 * @param 	bool	$no_excel
	 * @param	bool	$postprocessed_sorting	This setting should be used for all columns which are
	 *											subjected to postprocessing not conserving order.
	 */
	public function defineFieldColumn(
		$title,
		$column_id,
		array $fields = array(),
		$selectable = false,
		$sort = true,
		$no_excel =  false,
		$postprocessed_sorting = false) {

		$this->fields[$column_id] = $fields;
		$this->order[] = $column_id;
		if($selectable) {
			$this->selectable[$column_id] = array('txt' => $title);
			if($sort) {
				$this->selectable[$column_id]['sort'] = $column_id;
			}
			$this->selectable[$column_id]['no_excel'] = $no_excel;
		} else {
			$this->persistent[$column_id] = array('txt' => $title);
			if($sort) {
				$this->persistent[$column_id]['sort'] = $column_id;
			}
			$this->persistent[$column_id]['no_excel'] = $no_excel;
		}
		if($postprocessed_sorting) {
			$this->internal_sorting_columns[] = $column_id;
		}
		return $this;
	}

	/**
	 * @inheritdoc
	 */
	public function getSelectableColumns() {
		return $this->selectable;
	}

	/**
	 * Selectable-selected and persistent column info
	 *
	 * @return mixed[][]
	 */
	public function relevantColumns() {
		$relevant_column_info = array();
		$relevant_column_info_pre = array();
		foreach ($this->persistent as $column_id => $vals) {
			$relevant_column_info_pre[$column_id] = $vals;
		}
		foreach ($this->getSelectedColumns() as $column_id => $vals) {
			$relevant_column_info_pre[$column_id] = $this->selectable[$column_id];
		}
		foreach ($this->order as $column_id) {
			if(isset($relevant_column_info_pre[$column_id])) {
				$relevant_column_info[$column_id] = $relevant_column_info_pre[$column_id];
			}
		}
		return $relevant_column_info;
	}

	/**
	 * Fields associated with relevant columns
	 *
	 * @return Field[]
	 */
	protected function relevantFields() {
		$return = array();
		foreach ($this->relevantColumns() as $column_id => $vals) {
			$return = array_merge($return, $this->fields[$column_id]);
		}
		return $return;
	}

	/**
	 * Field ids associated with relevant columns
	 *
	 * @return string[]
	 */
	protected function relevantFieldIds() {
		return array_keys($this->relevantFields());
	}

	/**
	 * @inheritdoc
	 */
	public function fillRow($set) {
		$relevant = $this->relevantColumns();

		foreach ($this->order as $column_id) {
			if(isset($relevant[$column_id])) {
				$this->tpl->setCurrentBlock($column_id);
				$this->tpl->setVariable('VAL_'.strtoupper($column_id),(string)$set[$column_id]);
				$this->tpl->parseCurrentBlock();
			}
		}
	}

	/**
	 * According to selection addColumns
	 */
	protected function spanColumns() {
		$this->addColumn("", "blank", "0px", false);
		$relevant = $this->relevantColumns();
		foreach ($this->order as $column_id) {
			if(isset($relevant[$column_id])) {
				if(isset($relevant[$column_id]['sort'])) {
					$this->addColumn($relevant[$column_id]['txt'],$relevant[$column_id]['sort']);
				} else {
					$this->addColumn($relevant[$column_id]['txt']);
				}
			}
		}
	}

	/**
	 * According to selection request fields from space
	 */
	public function prepareTableAndSetRelevantFields($space) {
		$this->determineSelectedColumns();
		$this->spanColumns();
		$this->setExternalSorting(true);
		foreach($this->relevantFields() as $id => $field) {
			$space->request($field,$id);
		}
		$this->determineOffsetAndOrder(true);
		$order_column_id = $this->getOrderField();
		if(isset($this->relevantColumns()[$order_column_id])) {
			$order_direction = $this->getOrderDirection();
			if(in_array($order_column_id, $this->internal_sorting_columns)) {
				$this->setExternalSorting(false);
			} else {
				$space->orderBy( array_keys($this->fields[$order_column_id]),$order_direction);
			}
		} else {
			$space->orderBy(array(key($this->relevantColumns())),'asc');
		}
		return $space;
	}

}