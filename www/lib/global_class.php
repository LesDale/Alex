<?php
require_once "config_class.php";
require_once "checkvalid_class.php";
require_once "database_class.php";

abstract class GlobalClass{
	private $db;
	private $table_name;
	protected $config;
	protected $valid;
	
	protected function __construct($table_name, $db){
		$this->db=$db;
		$this->table_name=$table_name;
		$this->config= new Config();
		$this->valid= new CheckValid();
	}
	// добавление новой записи
	protected function add($new_values){
		return $this->db->insert($this->table_name, $new_values);
	}
	// обновление поля по ID
	protected function edit($id, $upd_fields){
		return $this->db->updateOnId($this->table_name, $id, $upd_fields);
	}
	// удаление записи по ID
	public function delete($id){
		return $this->db->deleteOnId($this->table_name, $id);
	}
	public function deleteAll(){
		return $this->db->deleteAll($this->table_name);
	}
	// получение поля по другому полю(поле которое нужно получить, входное поле, его значение)
	protected function getField($field_out, $field_in, $value_in){
		return $this->db->getField($this->table_name, $field_out, $field_in, $value_in);
	}
	// получение поля по ID
	protected function getFieldOnId($id, $field){
		return $this->db->getFieldOnId($this->table_name, $id, $field);
	}
	// заменяет значение поля по ID
	protected function setFieldOnId($id, $field, $value){
		return $this->db->getFieldOnId($this->table_name, $id, $field, $value);
	}
	// получает всю запись по ID
	public function get($id){
		return $this->db->getElementOnId($this->table_name, $id);
	}
	// получает все записи из таблицы
	public function getAll($order="", $up=true){
		return $this->db->getAll($this->table_name, $order, $up);
	}
	// получает все записи по определенному полю
	protected function getAllOnFields($field, $value, $order="", $up=true){
		return $this->db->getAllOnField($this->table_name, $field, $value, $order, $up);
	}
	// получает случайные записи
	public function getRandomElement($count){
		return $this->db->getRabdomElements($this->table_name, $count);
	}
	// получение ID последней вставленной записи
	public function getLastId(){
		return $this->db->getLastId($this->table_name);
	}
	// количество элементов в данной таблице
	public function getCount(){
		return $this->db->getCount($this->table_name);
	}
	// проверка на существование поля
	protected function isExists($field, $value){
		return $this->db->isExists($this->table_name, $field, $value);
	}
	protected function search($words, $fields){
		return $this->db->search($this->table_name, $words, $fields);
	}
}
?>