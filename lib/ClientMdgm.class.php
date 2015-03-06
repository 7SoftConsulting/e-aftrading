<?php
	
	if(! defined('CLIENT_MDGM'))
	{
		if(! defined("COMMON_HTTP_SESSION_INCLUDED"))
		{
			include dirname(__FILE__)."/../../_PVIEW/Common/HttpSession.class.php" ;
		}
		if(! defined("EXPAT_XML_INCLUDED"))
		{
			include dirname(__FILE__)."/../../_PVIEW/ExpatXml/ExpatXml.class.php" ;
		}
		define('CLIENT_MDGM', 1) ;
		
		class SessionMdgm
		{
			public $Date ;
			public $Id ;
			public $ContenuBrut ;
		}
		class NotationMdgm
		{
			public $ContenuBrut ;
			public $EXPIRES ;
			public $AMOUNT ;
			public $FIRST ;
			public $DATETIME_FIRST ;
			public $DATE_FIRST ;
			public $TIME_FIRST ;
			public $PRICE ;
			public $DATETIME_PRICE ;
			public $DATE_PRICE ;
			public $TIME_PRICE ;
			public $SOURCE_PRICE ;
			public $VOLUME ;
			public $NUMBER_ORDERS ;
			public $ADDENDUM ;
			public $PROPERTY_FLAGS ;
			public $NUMBER_TRADING_DAY ;
			public $MONEY ;
			public $HIGH ;
			public $DATETIME_HIGH ;
			public $DATE_HIGH ;
			public $TIME_HIGH ;
			public $LOW ;
			public $DATETIME_LOW ;
			public $DATE_LOW ;
			public $TIME_LOW ;
			public $TOTAL_VOLUME ;
			public $TOTAL_MONEY ;
			public $NUMBER_PRICES ;
			public $PREVIOUS_LAST ;
			public $VOLUME_FIRST ;
			public $VOLUME_HIGH ;
			public $VOLUME_LOW ;
			public $DATETIME_PREVIOUS_LAST ;
			public $DATE_PREVIOUS_LAST ;
			public $TIME_PREVIOUS_LAST ;
			public $ID_TYPE_PRICE_FIRST ;
			public $ID_TYPE_PRICE ;
			public $ID_TYPE_PRICE_HIGH ;
			public $ID_TYPE_PRICE_LOW ;
			public $ID_TYPE_PRICE_PREVIOUS_LAST ;
			public $ID_TYPE_PRICE_TOTALS ;
			public $PERFORMANCE ;
			public $PERFORMANCE_PCT ;
			public $BASIS_PRICE_PERFORMANCE ;
			public $DATETIME_BASIS_PRICE_PERFORMANCE ;
			public $DATE_BASIS_PRICE_PERFORMANCE ;
			public $TIME_BASIS_PRICE_PERFORMANCE ;
			public $ID_NOTATION ;
			public $ID_TIMEZONE ;
			public $ID_EXCHANGE ;
			public $CODE_EXCHANGE ;
			public $ID_CONTRIBUTOR ;
			public $CODE_CONTRIBUTOR ;
			public $ID_CURRENCY ;
			public $ISO_CURRENCY ;
			public $ID_TRADING_SCHEDULE ;
			public $ID_INSTRUMENT ;
			public $ID_TYPE_INSTRUMENT ;
			public $CODE_TOOL ;
			public $ID_UNIT_PRICE ;
			public $ID_QUALITY_PRICE ;
			public $CODE_QUALITY_PRICE ;
			public $ID_SALES_PRODUCT ;
			public $TRADER_BUY ;
			public $TRADER_SELL ;
			public function ParseCtnXml($result)
			{
				$xmlParser = new ExpatXmlParser() ;
				$docXml = $xmlParser->ParseContent($result) ;
				$noeudRacine = $docXml->RootNode() ;
				$data = $noeudRacine->ChildNodeToHash() ;
				$this->ContenuBrut = $result ;
				$this->EXPIRES = $noeudRacine->GetAttribute("EXPIRES") ;
				$this->AMOUNT = $noeudRacine->GetAttribute("AMOUNT") ;
				$this->FIRST = (isset($data["FIRST"])) ? $data["FIRST"] : null ;
				$this->DATETIME_FIRST = (isset($data["DATETIME_FIRST"])) ? $data["DATETIME_FIRST"] : null ;
				$this->DATE_FIRST = (isset($data["DATE_FIRST"])) ? $data["DATE_FIRST"] : null ;
				$this->TIME_FIRST = (isset($data["TIME_FIRST"])) ? $data["TIME_FIRST"] : null ;
				$this->PRICE = (isset($data["PRICE"])) ? $data["PRICE"] : null ;
				$this->DATETIME_PRICE = (isset($data["DATETIME_PRICE"])) ? $data["DATETIME_PRICE"] : null ;
				$this->DATE_PRICE = (isset($data["DATE_PRICE"])) ? $data["DATE_PRICE"] : null ;
				$this->TIME_PRICE = (isset($data["TIME_PRICE"])) ? $data["TIME_PRICE"] : null ;
				$this->SOURCE_PRICE = (isset($data["SOURCE_PRICE"])) ? $data["SOURCE_PRICE"] : null ;
				$this->VOLUME = (isset($data["VOLUME"])) ? $data["VOLUME"] : null ;
				$this->NUMBER_ORDERS = (isset($data["NUMBER_ORDERS"])) ? $data["NUMBER_ORDERS"] : null ;
				$this->ADDENDUM = (isset($data["ADDENDUM"])) ? $data["ADDENDUM"] : null ;
				$this->PROPERTY_FLAGS = (isset($data["PROPERTY_FLAGS"])) ? $data["PROPERTY_FLAGS"] : null ;
				$this->NUMBER_TRADING_DAY = (isset($data["NUMBER_TRADING_DAY"])) ? $data["NUMBER_TRADING_DAY"] : null ;
				$this->MONEY = (isset($data["MONEY"])) ? $data["MONEY"] : null ;
				$this->HIGH = (isset($data["HIGH"])) ? $data["HIGH"] : null ;
				$this->DATETIME_HIGH = (isset($data["DATETIME_HIGH"])) ? $data["DATETIME_HIGH"] : null ;
				$this->DATE_HIGH = (isset($data["DATE_HIGH"])) ? $data["DATE_HIGH"] : null ;
				$this->TIME_HIGH = (isset($data["TIME_HIGH"])) ? $data["TIME_HIGH"] : null ;
				$this->LOW = (isset($data["LOW"])) ? $data["LOW"] : null ;
				$this->DATETIME_LOW = (isset($data["DATETIME_LOW"])) ? $data["DATETIME_LOW"] : null ;
				$this->DATE_LOW = (isset($data["DATE_LOW"])) ? $data["DATE_LOW"] : null ;
				$this->TIME_LOW = (isset($data["TIME_LOW"])) ? $data["TIME_LOW"] : null ;
				$this->TOTAL_VOLUME = (isset($data["TOTAL_VOLUME"])) ? $data["TOTAL_VOLUME"] : null ;
				$this->TOTAL_MONEY = (isset($data["TOTAL_MONEY"])) ? $data["TOTAL_MONEY"] : null ;
				$this->NUMBER_PRICES = (isset($data["NUMBER_PRICES"])) ? $data["NUMBER_PRICES"] : null ;
				$this->PREVIOUS_LAST = (isset($data["PREVIOUS_LAST"])) ? $data["PREVIOUS_LAST"] : null ;
				$this->VOLUME_FIRST = (isset($data["VOLUME_FIRST"])) ? $data["VOLUME_FIRST"] : null ;
				$this->VOLUME_HIGH = (isset($data["VOLUME_HIGH"])) ? $data["VOLUME_HIGH"] : null ;
				$this->VOLUME_LOW = (isset($data["VOLUME_LOW"])) ? $data["VOLUME_LOW"] : null ;
				$this->DATETIME_PREVIOUS_LAST = (isset($data["DATETIME_PREVIOUS_LAST"])) ? $data["DATETIME_PREVIOUS_LAST"] : null ;
				$this->DATE_PREVIOUS_LAST = (isset($data["DATE_PREVIOUS_LAST"])) ? $data["DATE_PREVIOUS_LAST"] : null ;
				$this->TIME_PREVIOUS_LAST = (isset($data["TIME_PREVIOUS_LAST"])) ? $data["TIME_PREVIOUS_LAST"] : null ;
				$this->ID_TYPE_PRICE_FIRST = (isset($data["ID_TYPE_PRICE_FIRST"])) ? $data["ID_TYPE_PRICE_FIRST"] : null ;
				$this->ID_TYPE_PRICE = (isset($data["ID_TYPE_PRICE"])) ? $data["ID_TYPE_PRICE"] : null ;
				$this->ID_TYPE_PRICE_HIGH = (isset($data["ID_TYPE_PRICE_HIGH"])) ? $data["ID_TYPE_PRICE_HIGH"] : null ;
				$this->ID_TYPE_PRICE_LOW = (isset($data["ID_TYPE_PRICE_LOW"])) ? $data["ID_TYPE_PRICE_LOW"] : null ;
				$this->ID_TYPE_PRICE_PREVIOUS_LAST = (isset($data["ID_TYPE_PRICE_PREVIOUS_LAST"])) ? $data["ID_TYPE_PRICE_PREVIOUS_LAST"] : null ;
				$this->ID_TYPE_PRICE_TOTALS = (isset($data["ID_TYPE_PRICE_TOTALS"])) ? $data["ID_TYPE_PRICE_TOTALS"] : null ;
				$this->PERFORMANCE = (isset($data["PERFORMANCE"])) ? $data["PERFORMANCE"] : null ;
				$this->PERFORMANCE_PCT = (isset($data["PERFORMANCE_PCT"])) ? $data["PERFORMANCE_PCT"] : null ;
				$this->BASIS_PRICE_PERFORMANCE = (isset($data["BASIS_PRICE_PERFORMANCE"])) ? $data["BASIS_PRICE_PERFORMANCE"] : null ;
				$this->DATETIME_BASIS_PRICE_PERFORMANCE = (isset($data["DATETIME_BASIS_PRICE_PERFORMANCE"])) ? $data["DATETIME_BASIS_PRICE_PERFORMANCE"] : null ;
				$this->DATE_BASIS_PRICE_PERFORMANCE = (isset($data["DATE_BASIS_PRICE_PERFORMANCE"])) ? $data["DATE_BASIS_PRICE_PERFORMANCE"] : null ;
				$this->TIME_BASIS_PRICE_PERFORMANCE = (isset($data["TIME_BASIS_PRICE_PERFORMANCE"])) ? $data["TIME_BASIS_PRICE_PERFORMANCE"] : null ;
				$this->ID_NOTATION = (isset($data["ID_NOTATION"])) ? $data["ID_NOTATION"] : null ;
				$this->ID_TIMEZONE = (isset($data["ID_TIMEZONE"])) ? $data["ID_TIMEZONE"] : null ;
				$this->ID_EXCHANGE = (isset($data["ID_EXCHANGE"])) ? $data["ID_EXCHANGE"] : null ;
				$this->CODE_EXCHANGE = (isset($data["CODE_EXCHANGE"])) ? $data["CODE_EXCHANGE"] : null ;
				$this->ID_CONTRIBUTOR = (isset($data["ID_CONTRIBUTOR"])) ? $data["ID_CONTRIBUTOR"] : null ;
				$this->CODE_CONTRIBUTOR = (isset($data["CODE_CONTRIBUTOR"])) ? $data["CODE_CONTRIBUTOR"] : null ;
				$this->ID_CURRENCY = (isset($data["ID_CURRENCY"])) ? $data["ID_CURRENCY"] : null ;
				$this->ISO_CURRENCY = (isset($data["ISO_CURRENCY"])) ? $data["ISO_CURRENCY"] : null ;
				$this->ID_TRADING_SCHEDULE = (isset($data["ID_TRADING_SCHEDULE"])) ? $data["ID_TRADING_SCHEDULE"] : null ;
				$this->ID_INSTRUMENT = (isset($data["ID_INSTRUMENT"])) ? $data["ID_INSTRUMENT"] : null ;
				$this->ID_TYPE_INSTRUMENT = (isset($data["ID_TYPE_INSTRUMENT"])) ? $data["ID_TYPE_INSTRUMENT"] : null ;
				$this->CODE_TOOL = (isset($data["CODE_TOOL"])) ? $data["CODE_TOOL"] : null ;
				$this->ID_UNIT_PRICE = (isset($data["ID_UNIT_PRICE"])) ? $data["ID_UNIT_PRICE"] : null ;
				$this->ID_QUALITY_PRICE = (isset($data["ID_QUALITY_PRICE"])) ? $data["ID_QUALITY_PRICE"] : null ;
				$this->CODE_QUALITY_PRICE = (isset($data["CODE_QUALITY_PRICE"])) ? $data["CODE_QUALITY_PRICE"] : null ;
				$this->ID_SALES_PRODUCT = (isset($data["ID_SALES_PRODUCT"])) ? $data["ID_SALES_PRODUCT"] : null ;
				$this->TRADER_BUY = (isset($data["TRADER_BUY"])) ? $data["TRADER_BUY"] : null ;
				$this->TRADER_SELL = (isset($data["TRADER_SELL"])) ? $data["TRADER_SELL"] : null ;
				$this->AMOUNT = (isset($data["AMOUNT"])) ? $data["AMOUNT"] : null ;
			}
		}
		
		class ClientMdgm
		{
			public $ClientHttp ;
			public $IdApp = '13048' ;
			public $LoginApp = 'id13048' ;
			public $PasswordApp = 'qk8WsHDz4A' ;
			public $Session ;
			protected function InitClientHttp()
			{
				$this->ClientHttp = new HttpSession() ;
			}
			public function Connecte()
			{
				$this->InitClientHttp() ;
				$entetes = array("Authorization" => "Basic ".base64_encode($this->LoginApp.":".$this->PasswordApp)) ;
				$this->Session = new SessionMdgm() ;
				// $entetes = array() ;
				$result = $this->ClientHttp->GetPage("https://xml-ssl.mdgms.com/session.xml?ID_CUST_XML=13048", array(), $entetes) ;
				// $result = $this->ResultConnecteTest() ;
				preg_match_all('@<XID DATE="([^"]+)">([^<]+)</XID>@', $result, $matches) ;
				if(count($matches[0]) > 0 && $matches[0][0] != '')
				{
					$this->Session->ContenuBrut = $matches[0][0] ;
					$this->Session->Date = $matches[1][0] ;
					$this->Session->Id = $matches[2][0] ;
				}
				return $this->EstConnecte() ;
			}
			public function EstConnecte()
			{
				return $this->Session != null && $this->Session->Id != '' ;
			}
			public function Notation($idNotation)
			{
				$notation = new NotationMdgm() ;
				if(! $this->EstConnecte())
				{
					return $notation ;
				}
				$url = "http://xml.mdgms.com/prices/price.csv?XID=".urlencode($this->Session->Id)."&VERSION=2&ID_NOTATION=".urlencode($idNotation) ;
				$result = $this->ClientHttp->GetPage($url) ;
				// $result = $this->ResultNotationTest() ;
				$notation->ParseCtnXml($result) ;
				return $notation ;
			}
			public function Deconnecte()
			{
				
			}
			protected function ResultConnecteTest()
			{
				$ctn = '<?xml version="1.0" encoding="ISO-8859-1"?>
<XID DATE="2015-01-16">31333034383b32f8-54b997ef-d81c537d6bd942b7</XID>' ;
				return $ctn ;
			}
			protected function ResultNotationTest()
			{
				$ctn = '<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE PRICE SYSTEM "http://xml.mdgms.com/V2/prices/price_2.6.0.dtd">
<PRICE EXPIRES="1421451057" AMOUNT="1">
<FIRST>1.1636</FIRST>
<DATETIME_FIRST>2015-01-16T00:00:04</DATETIME_FIRST>
<DATE_FIRST>01/16</DATE_FIRST>
<TIME_FIRST>00:00:04</TIME_FIRST>
<PRICE>1.1570</PRICE>
<DATETIME_PRICE>2015-01-16T22:36:01</DATETIME_PRICE>
<DATE_PRICE>01/16</DATE_PRICE>
<TIME_PRICE>22:36:01</TIME_PRICE>
<SOURCE_PRICE></SOURCE_PRICE>
<VOLUME>n.a.</VOLUME>
<NUMBER_ORDERS>n.a.</NUMBER_ORDERS>
<ADDENDUM></ADDENDUM>
<PROPERTY_FLAGS>32</PROPERTY_FLAGS>
<NUMBER_TRADING_DAY>16451</NUMBER_TRADING_DAY>
<MONEY>n.a.</MONEY>
<HIGH>1.1650</HIGH>
<DATETIME_HIGH>2015-01-16T07:39:53</DATETIME_HIGH>
<DATE_HIGH>01/16</DATE_HIGH>
<TIME_HIGH>07:39:53</TIME_HIGH>
<LOW>1.1458</LOW>
<DATETIME_LOW>2015-01-16T15:46:48</DATETIME_LOW>
<DATE_LOW>01/16</DATE_LOW>
<TIME_LOW>15:46:48</TIME_LOW>
<TOTAL_VOLUME>n.a.</TOTAL_VOLUME>
<TOTAL_MONEY>n.a.</TOTAL_MONEY>
<NUMBER_PRICES>2,964,950</NUMBER_PRICES>
<PREVIOUS_LAST>1.1637</PREVIOUS_LAST>
<VOLUME_FIRST>n.a.</VOLUME_FIRST>
<VOLUME_HIGH>n.a.</VOLUME_HIGH>
<VOLUME_LOW>n.a.</VOLUME_LOW>
<DATETIME_PREVIOUS_LAST>2015-01-15T23:59:59</DATETIME_PREVIOUS_LAST>
<DATE_PREVIOUS_LAST>01/15</DATE_PREVIOUS_LAST>
<TIME_PREVIOUS_LAST>23:59:59</TIME_PREVIOUS_LAST>
<ID_TYPE_PRICE_FIRST>100</ID_TYPE_PRICE_FIRST>
<ID_TYPE_PRICE>128</ID_TYPE_PRICE>
<ID_TYPE_PRICE_HIGH>128</ID_TYPE_PRICE_HIGH>
<ID_TYPE_PRICE_LOW>100</ID_TYPE_PRICE_LOW>
<ID_TYPE_PRICE_PREVIOUS_LAST>128</ID_TYPE_PRICE_PREVIOUS_LAST>
<ID_TYPE_PRICE_TOTALS></ID_TYPE_PRICE_TOTALS>
<PERFORMANCE>n.a.</PERFORMANCE>
<PERFORMANCE_PCT>n.a.</PERFORMANCE_PCT>
<BASIS_PRICE_PERFORMANCE>n.a.</BASIS_PRICE_PERFORMANCE>
<DATETIME_BASIS_PRICE_PERFORMANCE>n.a.</DATETIME_BASIS_PRICE_PERFORMANCE>
<DATE_BASIS_PRICE_PERFORMANCE>n.a.</DATE_BASIS_PRICE_PERFORMANCE>
<TIME_BASIS_PRICE_PERFORMANCE>n.a.</TIME_BASIS_PRICE_PERFORMANCE>
<ID_NOTATION>1390634</ID_NOTATION>
<ID_TIMEZONE>385</ID_TIMEZONE>
<ID_EXCHANGE>761</ID_EXCHANGE>
<CODE_EXCHANGE>@W$</CODE_EXCHANGE>
<ID_CONTRIBUTOR>2</ID_CONTRIBUTOR>
<CODE_CONTRIBUTOR>$$$$</CODE_CONTRIBUTOR>
<ID_CURRENCY>194</ID_CURRENCY>
<ISO_CURRENCY>USD</ISO_CURRENCY>
<ID_TRADING_SCHEDULE>14</ID_TRADING_SCHEDULE>
<ID_INSTRUMENT>14959435</ID_INSTRUMENT>
<ID_TYPE_INSTRUMENT>5</ID_TYPE_INSTRUMENT>
<CODE_TOOL>CUR</CODE_TOOL>
<ID_UNIT_PRICE>1</ID_UNIT_PRICE>
<ID_QUALITY_PRICE>2</ID_QUALITY_PRICE>
<CODE_QUALITY_PRICE>DLY</CODE_QUALITY_PRICE>
<ID_SALES_PRODUCT>16845</ID_SALES_PRODUCT>
<TRADER_BUY></TRADER_BUY>
<TRADER_SELL></TRADER_SELL>
<AMOUNT>1</AMOUNT>
</PRICE>' ;
				return $ctn ;
			}
		}
	}
	
?>