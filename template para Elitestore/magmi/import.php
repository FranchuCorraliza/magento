<?php
require_once("./inc/magmi_defs.php");
require_once("./integration/inc/magmi_datapump.php"); 
require_once "../app/Mage.php";
Mage::app();
umask(0);


$dir = "./files/";
$dir_processing = $dir.'processing/';
$files = scandir($dir_processing);
$files = array_diff(scandir($dir_processing), array('..', '.'));
foreach($files as $file){
	$file = $dir_processing.$file;
	$dp = Magmi_DataPumpFactory::getDataPumpInstance("productimport"); // create a Product import Datapump using Magmi_DatapumpFactory
	$dp->beginImportSession("default","create"); // Available modes: "create" creates and updates items, "update" updates only, "xcreate creates only. || Important: for values other than "default" profile has to be an existing magmi profile 
	$handle = fopen($file,"r")  or die("no puedo leer el fichero ->".$file);
	if($handle){
		$contaLineas = 0;
		$cabecerasLinea = array();
		while (($data = fgetcsv($handle, 6000, ',')) !== FALSE) {
			if($contaLineas==0):
				$cabecerasLinea = $data;
				$posicion_sku = array_search('sku',$cabecerasLinea);
			else:
				$contaCampos = 0;
				foreach($data as $valor){
					$item[$cabecerasLinea[$contaCampos]] = $valor; //asigno los valores a sus cabeceras por linea	
					$contaCampos++;
				}
				try{
					$sku=$data[$posicion_sku];
					echo "<hr>Importando producto $sku<br/>";
					print_r($item);
					$dp->ingest($item); //insert item 
					unset($item); 		//clean item
					echo "<hr>";
				} catch (Exception $ex){ 
					alertOnError("CREAR ITEM",$ex->getMessage());
				}
			endif;
			$contaLineas++;
		} //end while bucle for line
			fclose($handle);		//close file
			
		
	}
	$dp->endImportSession();
	
	echo "<hr>Fin de la importación<hr>";
	echo "<hr>Iniciamos la creación de rewrites<hr>";
	
	$handle = fopen($file,"r")  or die("no puedo leer el fichero ->".$file);
	if($handle){
		$contaLineas = 0;
		$cabecerasLinea = array();
		while (($data = fgetcsv($handle, 6000, ',')) !== FALSE) {
			if($contaLineas==0):
				$cabecerasLinea = $data;
				$posicion_sku = array_search('sku',$cabecerasLinea);
				$posicion_type = array_search('type',$cabecerasLinea);
				
			else:
				$type=$data[$posicion_type];
				$sku=$data[$posicion_sku];
				echo "<hr>Creamos Urls para el producto $sku<br/>";
				echo "posicion:".$posicion_type." -- tipo: ".$type."<br/>";
				if ($data[$posicion_type]=='configurable'):
					$product=Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
					createBrandsCategoryPages($product);
					createBrandsDesignerLinePages($product);
					createBrandsRunwayPage($product);
					//addGenderTypeToDesigner($product);
				endif;
				
			endif;
			$contaLineas++;
		} //end while bucle for line
			fclose($handle);		//close file
			
		
	}
	
	echo "<hr>Fin de la creación de rewrites<hr>";

}

function createBrandsCategoryPages($product){
		$attr = $product->getResource()->getAttribute("manufacturer");
		if ($attr->usesSource()) {
			$manufacturerId = $attr->getSource()->getOptionId($product->getAttributeText('manufacturer'));
		}
		$categories = getCategoriasAptas($product);
		echo "Este producto pertenece a las categorías:";
		print_r($categories);
		echo "y a la marca " . $product->getAttributeText('manufacturer')."<br/>";
		foreach ($categories as $categoryId):
			createUrlPath($categoryId, $manufacturerId,$product->getAttributeText('manufacturer'));
		endforeach;
}

function getCategoriasAptas($product){
		$categories = $product->getCategoryIds();
		//En Categorias Aptas se encuentran todas las categorias que cuelgan de Women, Men y Kids, ellas inclusive.
		$categoriasAptas=array(1003,1004,1005,1005,1006,1006,1007,1007,1008,1008,1009,1009,1010,1010,1011,1011,1012,1012,1013,1014,1014,1015,1015,1016,1016,1017,1017,1018,1018,1019,1019,1020,1020,1021,1021,1022,1023,1023,1024,1024,1025,1025,1026,1026,1027,1028,1028,1029,1030,1030,1031,1031,1032,1032,1033,1033,1034,1034,1035,1036,1036,1037,1037,1038,1038,1039,1040,1040,1041,1041,1042,1042,1043,1043,1044,1044,1045,1045,1046,1047,1048,1048,1049,1049,1050,1050,1051,1052,1052,1053,1053,1054,1054,1055,1055,1056,1056,1057,1057,1058,1058,1059,1059,1060,1060,1061,1062,1062,1063,1063,1064,1064,1065,1065,1066,1066,1067,1067,1068,1069,1069,1070,1070,1071,1071,1073,1074,1075,1075,1076,1076,1077,1077,1078,1078,1079,1080,1080,1081,1081,1082,1082,1083,1083,1084,1084,1085,1085,1086,1087,1087,1088,1088,1089,1089,1090,1090,1091,1091,1092,1093,1093,1094,1094,1095,1095,1096,1096,1097,1098,1098,1099,1099,1100,1100,1101,1102,1102,1103,1103,1104,1104,1105,1105,1106,1106,1107,1107,1108,1108,1109,1110,1111,1111,1112,1112,1113,1113,1114,1115,1115,1116,1116,1117,1117,1118,1118,1119,1119,1120,1120,1121,1121,1122,1122,1123,1123,1124,1124,1125,1125,1126,1126,1127,1128,1128,1129,1129,1130,1130,1131,1131,1132,1132,1133,1133,1134,1134,1135,1136,1136,1137,1137,1138,1138,1140,1141,1141,1142,1143,1143,1144,1144,1145,1145,1146,1146,1147,1147,1148,1148,1149,1149,1151,1152,1153,1154,1154,1155,1155,1156,1156,1157,1157,1158,1158,1159,1159,1160,1160,1161,1161,1162,1163,1163,1164,1164,1165,1165,1166,1166,1167,1167,1168,1168,1169,1169,1170,1170,1171,1172,1172,1173,1173,1174,1174,1175,1175,1176,1177,1177,1178,1179,1179,1180,1180,1181,1181,1182,1182,1183,1183,1184,1185,1185,1186,1186,1187,1187,1188,1189,1189,1190,1190,1191,1191,1192,1192,1193,1193,1194,1194,1195,1196,1197,1197,1198,1198,1199,1199,1200,1202,1202,1203,1203,1204,1204,1205,1205,1201,1201,1206,1206,1207,1207,1208,1208,1209,1209,1210,1211,1211,1212,1212,1213,1213,1214,1214,1215,1215,1216,1216,1217,1218,1218,1219,1219,1220,1220,1221,1222,1223,1224,1224,1225,1225,1226,1226,1227,1227,1228,1229,1229,1230,1230,1231,1231,1232,1232,1233,1233,1234,1234,1235,1235,1236,1237,1237,1238,1238,1239,1239,1240,1240,1241,1242,1242,1243,1243,1244,1244,1245,1245,1246,1247,1247,1248,1248,1249,1249,1250,1251,1251,1252,1252,1253,1253,1254,1254,1255,1255,1256,1256,1257,1257,1258,1259,1260,1260,1261,1261,1262,1262,1263,1264,1264,1265,1265,1266,1266,1267,1267,1268,1268,1269,1269,1270,1270,1271,1271,1272,1272,1273,1273,1274,1274,1275,1275,1276,1277,1277,1278,1278,1279,1279,1280,1280,1281,1281,1282,1282,1283,1283,1284,1285,1285,1286,1286,1287,1287,1288,1289,1290,1290,1291,1292,1292,1293,1293,1294,1294,1295,1295,1296,1296,1297,1297,1299,1300,1301,1302,1302,1303,1303,1304,1304,1305,1305,1306,1306,1307,1307,1308,1308,1309,1309,1310,1311,1311,1312,1312,1313,1313,1314,1314,1315,1315,1316,1316,1317,1317,1318,1318,1319,1320,1320,1321,1321,1322,1322,1323,1323,1324,1325,1325,1326,1327,1327,1328,1328,1329,1329,1330,1330,1331,1331,1332,1333,1333,1334,1334,1335,1335,1336,1337,1337,1338,1338,1339,1339,1340,1340,1341,1341,1342,1342,1343,1344,1345,1345,1346,1346,1347,1347,1348,1350,1350,1351,1351,1352,1352,1353,1353,1349,1349,1354,1354,1355,1355,1356,1356,1357,1357,1358,1359,1359,1360,1360,1361,1361,1362,1362,1363,1363,1364,1364,1365,1366,1366,1367,1367,1368,1368,1369,1370,1371,1372,1372,1373,1373,1374,1374,1375,1375,1376,1377,1377,1378,1378,1379,1379,1380,1380,1381,1381,1382,1382,1383,1383,1384,1385,1385,1386,1386,1387,1387,1388,1388,1389,1390,1390,1391,1391,1392,1392,1393,1393,1394,1395,1395,1396,1396,1397,1397,1398,1399,1399,1400,1400,1401,1401,1402,1402,1403,1403,1404,1404,1405,1405,1406,1407,1408,1408,1422,1422,1409,1409,1423,1423,1410,1410,1411,1412,1412,1413,1413,1414,1414,1415,1415,1416,1416,1417,1417,1418,1418,1419,1419,1420,1420,1421,1421,1424,1425,1425,1426,1426,1427,1427,1428,1428,1429,1429,1430,1430,1431,1431,1432,1433,1433,1434,1434,1435,1435,1436,1437,1438,1438,1439,1440,1440,1441,1441,1442,1442,1443,1443,1444,1444,1445,1445,1446,1446);
		$categories = array_intersect($categories,$categoriasAptas);
		return $categories;
}

function createUrlPath($categoryId, $manufacturerId,$manufacturerName){
		if($manufacturerId!=""){
			$category=Mage::getModel("catalog/category")->load($categoryId);
			
			if ($category->getParentCategory()->getLevel()>1){
				createUrlPath($category->getParentCategory()->getId(),$manufacturerId,$manufacturerName);
			}
			$resource = Mage::getSingleton('core/resource');
			$manufacturerUrlKey = Mage::helper('manufacturer')->refineUrlKey($manufacturerName);
			$categoryUrlPath=$category->getUrlPath();
			$id_path="manufacturer/".$manufacturerId.'/'.$categoryId;
			$targetPath='catalog/category/view/id/'.$categoryId.'?manufacturer='.$manufacturerId.'&sc=1';
			$requestPath=$manufacturerUrlKey.'/'.$categoryUrlPath;
			echo "Creando URL para la categoria ".$category->getName()." y diseñador ".$manufacturerName. " con url_key ".$manufacturerUrlKey."<br/>";
			echo 'request Path:'.$requestPath."<br/>";
			echo 'id_path:'.$id_path."<br/>";
			echo 'targetPath:'.$targetPath."<br/>";
			if (!(Mage::getModel('core/url_rewrite')->loadByIdPath($id_path)->getId())): 
					Mage::getModel('core/url_rewrite')
						->setIsSystem(0)
						->setOptions()
						->setIdPath($id_path)
						->setTargetPath($targetPath)
						->setRequestPath($requestPath)
						->save();
					
			endif;
		}
		
}

function createBrandsDesignerLinePages($product){
		$designerlineName = $product->getAttributeText('designer_line');
		if ($designerlineName!=''):
			Mage::log('Este producto pertenece a la linea de diseño '.$designerlineName,null,'import.log');
			$attr = $product->getResource()->getAttribute("manufacturer");
			if ($attr->usesSource()):
				$manufacturerId = $attr->getSource()->getOptionId($product->getAttributeText('manufacturer'));
			endif;
			$categories = getCategoriasAptas($product);
			foreach ($categories as $categoryId):
				$category= Mage::getModel('catalog/category')->load($categoryId);
				$parentCategoryId = explode('/',$category->getPath())[2];
				$parentCategoryName = strtolower(Mage::getModel('catalog/category')->load($parentCategoryId)->getName());
				
				$attr2 = $product->getResource()->getAttribute("designer_line");
				if ($attr2->usesSource()):
					$designerlineId = $attr2->getSource()->getOptionId($designerlineName);
				endif;
				$designerlineName=Mage::getModel('catalog/product_url')->formatUrlKey($designerlineName);
				$manufacturerUrlKey = Mage::helper('manufacturer')->refineUrlKey($product->getAttributeText('manufacturer'));
				echo 'Creando URL para la linea de diseño '. $designerlineName .',la categoria '.$category->getName().' y diseñador '.$manufacturerUrlKey.'<br/>';
				$id_path="designerline/".$designerlineId.'/'.$manufacturerId.'/'.$parentCategoryId;
				$targetPath='catalog/category/view/id/'.$parentCategoryId.'?manufacturer='.$manufacturerId.'&designer_line='.$designerlineId.'&sc=1';
				$requestPath=$manufacturerUrlKey.'/'.$designerlineName.'/'.$parentCategoryName;
				echo 'request Path:'.$requestPath."<br/>";
				echo 'id_path:'.$id_path."<br/>";
				echo 'targetPath:'.$targetPath."<br/>";
				if (!(Mage::getModel('core/url_rewrite')->loadByIdPath($id_path)->getId())): 
						Mage::getModel('core/url_rewrite')
							->setIsSystem(0)
							->setOptions()
							->setIdPath($id_path)
							->setTargetPath($targetPath)
							->setRequestPath($requestPath)
							->save();
						
				endif;
			endforeach;
		endif;
}

function createBrandsRunwayPage($product){
		if ($product->getData('runway')!=0):
			//Mage::log('Este producto pertenece a runway',null,'import.log');
			$attr = $product->getResource()->getAttribute("manufacturer");
			if ($attr->usesSource()):
				$manufacturerId = $attr->getSource()->getOptionId($product->getAttributeText('manufacturer'));
			endif;
			
			$categories = getCategoriasAptas($product);
			foreach ($categories as $categoryId):
				$category= Mage::getModel('catalog/category')->load($categoryId);
				$parentCategoryId = explode('/',$category->getPath())[2];
				$parentCategoryName = strtolower(Mage::getModel('catalog/category')->load($parentCategoryId)->getName());
			
				$manufacturerUrlKey = Mage::helper('manufacturer')->refineUrlKey($product->getAttributeText('manufacturer'));
				echo 'Creando URL para runway del diseñador '.$manufacturerUrlKey;
				
				$id_path="runway/".$manufacturerId.'/'.$parentCategoryId;
				$targetPath='catalog/category/view/id/'.$parentCategoryId.'?manufacturer='.$manufacturerId.'&runway=525&sc=1';
				$requestPath=$manufacturerUrlKey.'/runway/'.$parentCategoryName;
				echo 'request Path:'.$requestPath."<br/>";
				echo 'id_path:'.$id_path."<br/>";
				echo 'targetPath:'.$targetPath."<br/>";
				if (!(Mage::getModel('core/url_rewrite')->loadByIdPath($id_path)->getId())): 
						Mage::getModel('core/url_rewrite')
							->setIsSystem(0)
							->setOptions()
							->setIdPath($id_path)
							->setTargetPath($targetPath)
							->setRequestPath($requestPath)
							->save();
						
				endif;
			endforeach;
		endif;
	}

?>