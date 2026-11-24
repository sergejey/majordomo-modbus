<?php
/*
* @version 0.1 (wizard)
*/
 global $session;
  if ($this->owner->name=='panel') {
   $out['CONTROLPANEL']=1;
  }
  $qry="1";
  // search filters
  //searching 'TITLE' (varchar)
  global $title;
  if ($title!='') {
   $qry.=" AND TITLE LIKE '%".DBSafe($title)."%'";
   $out['TITLE']=$title;
  }
  // QUERY READY
  global $save_qry;
  if ($save_qry) {
   $qry=$session->data['modbusdevices_qry'];
  } else {
   $session->data['modbusdevices_qry']=$qry;
  }
  if (!$qry) $qry="1";
  // FIELDS ORDER
  global $sortby_modbusdevices;
  if (!$sortby_modbusdevices) {
   $sortby_modbusdevices=$session->data['modbusdevices_sort'];
  } else {
   if ($session->data['modbusdevices_sort']==$sortby_modbusdevices) {
    if (Is_Integer(strpos($sortby_modbusdevices, ' DESC'))) {
     $sortby_modbusdevices=str_replace(' DESC', '', $sortby_modbusdevices);
    } else {
     $sortby_modbusdevices=$sortby_modbusdevices." DESC";
    }
   }
   $session->data['modbusdevices_sort']=$sortby_modbusdevices;
  }
  // only known columns may get into ORDER BY
  if (!in_array($sortby_modbusdevices, array('ID', 'ID DESC', 'TITLE', 'TITLE DESC'))) $sortby_modbusdevices="ID DESC";
  $out['SORTBY']=$sortby_modbusdevices;
  // SEARCH RESULTS
  $res=SQLSelect("SELECT * FROM modbusdevices WHERE $qry ORDER BY ".$sortby_modbusdevices);
  if ($res[0]['ID']) {
   colorizeArray($res);
   $total=count($res);
   for($i=0;$i<$total;$i++) {
    foreach (array('TITLE', 'HOST', 'DATA', 'DATA_ORIGINAL') as $k) {
     $res[$i][$k]=htmlspecialchars((string)$res[$i][$k]);
    }
   }
   $out['RESULT']=$res;
  }
?>
