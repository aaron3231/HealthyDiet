<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
</head>

<body>
  <?php
  $mysqli = new mysqli("localhost", "root", "A110223036", "restaurant");

  if ($mysqli->connect_errno)
    die("無法建立資料連接: " . $mysqli->connect_error);

  $mysqli->query("SET NAMES utf8");
  $sql = 'SELECT r.*
		FROM `restaurant_testt` AS r
		';
  $where_sql_array=array();

  $restaurant_category_sql='';
  if (!empty($_GET['Restaurant_Category'])) {

    for ($x = 0; $x < count($_GET['Restaurant_Category']); $x++) {
      if ($x > 0) {
        $restaurant_category_sql .= " OR ";
      }
      $restaurant_category_sql .= "`Restaurant Category` = '" . $_GET['Restaurant_Category'][$x] . "'" . '
			';
    }
    array_push($where_sql_array, "(".$restaurant_category_sql.")");
  }

  $town_sql='';
  if (!empty($_GET['Town'])) {


    for ($x = 0; $x < count($_GET['Town']); $x++) {
      if ($x > 0) {
        $town_sql .= " OR ";
      }
      $town_sql .= "`Town` = '" . $_GET['Town'][$x] . "'" . '
			';
    }
    array_push($where_sql_array, "(".$town_sql.")");
  }

  $delivery_platform_sql='';
  if (!empty($_GET['Delivery_Platform'])) {

    for ($x = 0; $x < count($_GET['Delivery_Platform']); $x++) {
      if ($x > 0) {
        $delivery_platform_sql .= " OR ";
      }else {
        $delivery_platform_sql .= "`Delivery Platform` = '" . "Both" . "'" ." or ". '
    ';
      }
      $delivery_platform_sql .= "`Delivery Platform` = '" . $_GET['Delivery_Platform'][$x] . "'" . '
			';
    }
    array_push($where_sql_array, "(".$delivery_platform_sql.")");
  }

  $carrierinvoice_carrier_sql='';
  if (!empty($_GET['CarrierInvoice_Carrier'])) {


    for ($x = 0; $x < count($_GET['CarrierInvoice_Carrier']); $x++) {
      if ($x > 0) {
        $carrierinvoice_carrier_sql .= " OR ";
      }else {
        $carrierinvoice_carrier_sql .= "`Carrier (Invoice Carrier)` = '" . "Y" . "'" ." or ". '
        ';
      }
      $carrierinvoice_carrier_sql .= "`Carrier (Invoice Carrier)` = '" . $_GET['CarrierInvoice_Carrier'][$x] . "'" . '
			';
    }
    array_push($where_sql_array, "(".$carrierinvoice_carrier_sql.")");
  }

  $electronic_payment_sql='';
  if (!empty($_GET['Electronic_Payment'])) {


    for ($x = 0; $x < count($_GET['Electronic_Payment']); $x++) {
      if ($x > 0) {
        $electronic_payment_sql .= " OR ";
      }else {
        $electronic_payment_sql .= "`Electronic Payment` = '" . "Y" . "'" ." or ". '
        ';
      }
      $electronic_payment_sql .= "`Electronic Payment` = '" . $_GET['Electronic_Payment'][$x] . "'" . '
			';
    }
    array_push($where_sql_array, "(".$electronic_payment_sql.")");
  }

  $credit_card_sql='';
  if (!empty($_GET['Credit_Card'])) {
    for ($x = 0; $x < count($_GET['Credit_Card']); $x++) {
      if ($x > 0) {
        $credit_card_sql .= " OR ";
      }else {
        $credit_card_sql .= "`Credit Card` = '" . "Y" . "'" ." or ". '
        ';
      }
      $credit_card_sql .= "`Credit Card` = '" . $_GET['Credit_Card'][$x] . "'" . '
			';
    }
    array_push($where_sql_array, "(".$credit_card_sql.")");
  }

  $buffeta_la_carte_sql='';
  if (!empty($_GET['Buffet_A_La_Carte'])) {
    for ($x = 0; $x < count($_GET['Buffet_A_La_Carte']); $x++) {
      if ($x > 0) {
        $buffeta_la_carte_sql .= " OR ";
      }
      $buffeta_la_carte_sql .= "`Buffet/A La Carte` = '" . $_GET['Buffet_A_La_Carte'][$x] . "'" . '
			';
    }
    array_push($where_sql_array, "(".$buffeta_la_carte_sql.")");
  }

  $Average_Price_per_Person_sql='';
  if (!empty($_GET['Average_Price_per_Person'])) {

      $Average_Price_per_Person_sql .= "CAST( REGEXP_REPLACE(`Average Price per Person`,'\\\\$(\\\\d+)–(\\\\d+)','\\\\1') AS INT ) <= " . $_GET['Average_Price_per_Person'] . " AND CAST( REGEXP_REPLACE(`Average Price per Person`,'\\\\$(\\\\d+)–(\\\\d+)','\\\\2') AS INT ) >= " . $_GET['Average_Price_per_Person'] . '
			';
    
    array_push($where_sql_array, "(".$Average_Price_per_Person_sql.")");
  }


  $Google_Rating_sql='';
  if (!empty($_GET['Google_Rating'])) {

      $Google_Rating_sql .= " CAST( `Google_Rating` AS DOUBLE ) >= " . $_GET['Google_Rating'] . "" . '
			';
    array_push($where_sql_array, "(".$Google_Rating_sql.")");
  }


  $Number_of_Google_reviews_sql='';
  if (!empty($_GET['Number_of_Google_reviews'])) {

      $Number_of_Google_reviews_sql .= "CAST( `Number of Google reviews` AS INT ) >= " . $_GET['Number_of_Google_reviews'] . "" . '
			';
    array_push($where_sql_array, "(".$Number_of_Google_reviews_sql.")");
  }






if (count($where_sql_array) > 0) {
$sql.=" where ".join(' and ', $where_sql_array);
}

  $sql .= '
			ORDER BY r.ID
		';
    echo $sql;
  $result = $mysqli->query($sql);

  echo "<table border='1' align='center'><tr align='center'>";

  while ($field = $result->fetch_field())
    echo "<td>" . $field->name . "</td>";

  echo "</tr>";

  while ($row = $result->fetch_row()) {
    echo "<tr>";

    for ($i = 0; $i < $result->field_count; $i++)
      echo "<td>" . $row[$i] . "</td>";

    echo "</tr>";
  }



  echo "</table>";

  $result->free();
  $mysqli->close();
  ?>
</body>

</html>