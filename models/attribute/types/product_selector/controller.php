<?php  
defined('C5_EXECUTE') or die("Access Denied.");

class ProductSelectorAttributeTypeController extends AttributeTypeController  {

 	public function getValue() {
		$db = Loader::db();
		$value = $db->GetOne("select value from atProductSelector where avID = ?", array($this->getAttributeValueID()));
		return trim($value);	
	}
	
 	
 	public function form() {
		Loader::model('product/model', 'core_commerce');
		$product = null;
		
		if (is_object($this->attributeValue)) {
			$value = trim($this->getAttributeValue()->getValue());
			
			$product = CoreCommerceProduct::getByID($value);
		}
		
		$ak = $this->getAttributeKey();
		
		echo Loader::helper('html')->javascript('ccm.core.commerce.search.js', 'core_commerce');
		echo Loader::helper('html')->css('ccm.core.commerce.search.css', 'core_commerce');
		echo Loader::helper('form/product', 'core_commerce')->selectOne($this->getAttributeKey()->getAttributeKeyID() .'_productID', t('Select Product'), $product);	
	}

	public function saveValue($value) {
		$db = Loader::db();
		$db->Replace('atProductSelector', array('avID' => $this->getAttributeValueID(), 'value' => $value), 'avID', true);
	}
	
	public function deleteKey() {
		$db = Loader::db();
		$arr = $this->attributeKey->getAttributeValueIDList();
		foreach($arr as $id) {
			$db->Execute('delete from atProductSelector where avID = ?', array($id));
		}
	}
	
	public function saveForm($data) {
		$db = Loader::db();
		
		$this->saveValue($_POST[($this->getAttributeKey()->getAttributeKeyID() .'_productID')]);
	}
	
	public function deleteValue() {
		$db = Loader::db();
		$db->Execute('delete from atProductSelector where avID = ?', array($this->getAttributeValueID()));
	}
	
}