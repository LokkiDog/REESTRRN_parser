<?php 
function time_format($time){
  $date = date("Y-m-d");
  $months = [
      1 => 'января',
      2 => 'февраля',
      3 => 'марта',
      4 => 'апреля',
      5 => 'мая',
      6 => 'июня',
      7 => 'июля',
      8 => 'августа',
      9 => 'сентября',
      10 => 'октября',
      11 => 'ноября',
      12 => 'декабря'
    ];
  if (count(explode(' ', $time)) == 3){
      $explode_date = explode(' ', $time);
      $month_num = array_search( $explode_date[1], $months);
      $date = date("Y-m-d", strtotime($explode_date[0].'-'.$month_num.'-'.$explode_date[2]));
  }else{
      try{
          $date = date("Y-m-d", strtotime($time));
      }catch(Exception $e){
          echo 'Ошибка преобразования даты. Запишем текущую дату';
      }
  }
  return $date;
}
?>