<?php
// phpQueryの読み込み
require_once("./lib/phpQuery.php");
// HTMLデータを取得する
$From_URL = "http://goohome.jp/search/proplist?md=11&rtby=1&rttyp=&prptp=1%2C2&use=&pref=47&city=all&area=&rtprmax=0&rtprmin=0&rtspc=&exvmax=0&exvmin=0&lndmax=0&lndmin=0&lytgp=&lyt=&bltyr=0&stwk=0&img=&updt=0&sprht=&sploc=&spctr=&spstrct=&bldgstr=&spcnd=&spprk=&spgs=&spbth=&spair=&spclst=&spntwk=&spsec=&spoth2=&spuse=&spstat=&spoth=&odr=&ct=100&pg=1&lfboxsh=1";

$HTMLData = file_get_contents($From_URL);

// HTMLをオブジェクトとして扱う
$phpQueryObj = phpQuery::newDocument($HTMLData);

// trタグを片っ端からぶん回す



		foreach($phpQueryObj['tr'] as $val) {
			// 連続実行すると怒られちゃうのでとりあえず5秒待機
			//sleep(5);

			// pq()メソッドでオブジェクトとして再設定しつつさらに下ってhrefを取得
			//$title = pq($val)->find('td')->text();
			$data_val='';
			if($phpQueryObj['.date']){
				$data_val = pq($val)->find('.date')->text()."|";
				$data_val.= pq($val)->find('.address')->text()."|";
				$data_val.= pq($val)->find('.rent_price')->text()."|";
				$data_val.= pq($val)->find('.total_price')->text()."|";
				$data_val.= pq($val)->find('.room')->text()."|";
				$data_val.= pq($val)->find('.structure')->text();
			}

			$url = pq($val)->find('td')->find('div')->find('p')->find('a')->attr('href');
			//echo 'DATA：' . $title . PHP_EOL.",";
			if(!$url){
			}else{
				echo 'DATA:'.$data_val.'<br>';
				echo 'ページURL：'.'http://goohome.jp'. $url . PHP_EOL."<br>";
				//echo PHP_EOL.PHP_EOL."<br>";
				$url= 'http://goohome.jp'.$url;
			getChiledPage($url);
			}
		}
/**
 * もろもろ競合しちゃうと嫌なので関数化
 * 小見出しを取得して出力
 * @param string $url 子ページのURL
 */
function getChiledPage($url) {
	// ページを取得してオブジェクト化！
	$phpQueryObj = phpQuery::newDocument(file_get_contents($url));

	$data_val_d = $phpQueryObj->find("table:eq(0) tr:eq(1) td:eq(0)")->text().'|';
	$data_val_d .= $phpQueryObj->find("table:eq(0) tr:eq(1) td:eq(1)")->text().'|';
	$data_val_d .= $phpQueryObj->find("table:eq(0) tr:eq(1) td:eq(2)")->text().'|';
	$data_val_d .= $phpQueryObj->find("table:eq(0) tr:eq(1) td:eq(3)")->text().'|';
	$data_val_d .= $phpQueryObj->find("table:eq(0) tr:eq(1) td:eq(4)")->text().'|';
	$data_val_d .= $phpQueryObj->find("table:eq(0) tr:eq(1) td:eq(5)")->text().'|';
	$data_val_d .= $phpQueryObj->find("table:eq(0) tr:eq(1) td:eq(6)")->text().'|';
	$data_val_d .= $phpQueryObj->find("table:eq(0) tr:eq(1) td:eq(8)")->text();
	echo '詳細：'.$data_val_d.'<br>';
}
?>