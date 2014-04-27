<?php       

defined('C5_EXECUTE') or die(_("Access Denied."));

class ProductSelectorAttributePackage extends Package {

	protected $pkgHandle = 'product_selector_attribute';
	protected $appVersionRequired = '5.6.0';
	protected $pkgVersion = '0.9';
	
	public function getPackageDescription() {
		return t("Attribute that allows the selection of an eCommerce product");
	}
	
	public function getPackageName() {
		return t("eCommerce Product Selector Attribute");
	}
	
	public function install() {
		$installed = Package::getInstalledHandles();
		
		if( !(is_array($installed) && in_array('core_commerce',$installed)) ) {
			throw new Exception(t('This package requires that at least version 2.8.3 of the <a href="http://www.concrete5.org/marketplace/addons/ecommerce/" target="_blank">eCommerce package</a> is installed<br/>'));	
		}
		
		$pkg = Package::getByHandle('core_commerce');
		if (!is_object($pkg) || version_compare($pkg->getPackageVersion(), '2.8.3', '<')) {
			throw new Exception(t('You must upgrade the eCommerce add-on to version 2.8.3 or higher.'));
		}
		
		$pkg = parent::install();
		$pkgh = Package::getByHandle('product_selector_attribute'); 
		Loader::model('attribute/categories/collection');
		$col = AttributeKeyCategory::getByHandle('collection');
		$pageselector = AttributeType::add('product_selector', t('eCommerce Product'), $pkgh);
		$col->associateAttributeKeyType(AttributeType::getByHandle('product_selector'));
	}
}