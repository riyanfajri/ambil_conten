 <?php

 function bacaHTML($url){

    // inisialisasi CURL

    $data = curl_init();

    // setting CURL

    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($data, CURLOPT_URL, $url);

    // menjalankan CURL untuk membaca isi file

    $hasil = curl_exec($data);


    curl_close($data);

    return $hasil;

}

 $bacaHTML = bacaHTML("https://www.smithjankerman.id/");


//membuat dom dokumen

$dom = new DomDocument();


//mengambil html dari kompas untuk di parse


@$dom->loadHTML($bacaHTML);

 //nama class yang akan dicari

$classname="blog-posts";


//mencari class memakai dom query

$finder = new DomXPath($dom);

$spaner = $finder->query("//*[contains(@class, '$classname')]");



 //mengambil data dari class yang pertama
$span = $spaner->item(0);
//dari class pertama mengambil 2 elemen yaitu a yang menyimpan judul dan link dan span yang menyimpan tanggal
$urutan =  $span->getElementsByTagName('h2');

 $label =  $span->getElementsByTagName('h2');
 //$tanggal = $span->getElementsByTagName('div');


$link =  $span->getElementsByTagName('a');

$data =array();
foreach ($link as $link) {
    $ambil = substr($link->getAttribute('href'),30,7);
    $unik = array();

    if($ambil == "2019/07"){

    	$data[] = array(
    		  'link' => $link->getAttribute('href'),
    		 
    	);
    	//$ambil = $link->getAttribute('href')."<br>";
    }
}
$data = array_map("unserialize", array_unique(array_map("serialize", $data)));

foreach ($data as $key => $value) {
  $arr[] = $value;
}



?>
<table>
	<tr>
		<td>Judul</td>
		<td>Link</td>
	</tr>
	<?php
	$no = null;
		foreach ($arr as $key => $value) {
	?>
	<tr>
		<td><?php echo $label->item($no)->nodeValue; ?></td>
		<td><?php echo $value['link']; ?></td>
	</tr>
	<?php
	$no++;
}
	?>
</table>
