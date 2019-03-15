<?php
// Get API key from config.php
require 'config.php';
date_default_timezone_set('America/Denver');

function get_listings() {
  global $API_KEY;
  $curl = curl_init();
  $url = 'https://api.sightmap.com/v1/assets/1273/multifamily/units?per-page=100';
  curl_setopt( $curl, CURLOPT_URL, $url );
  curl_setopt( $curl, CURLOPT_HTTPHEADER, array (
    'API-Key: ' . $API_KEY
  ));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec( $curl );
  $body = json_decode( $response );
  curl_close( $curl );
  return $body;
}

$get_listings = get_listings();
$data = $get_listings->data; ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Sightmap</title>

<link type="text/css" media="all" href="/css/style.css" rel="stylesheet" />
</head>

<body>
  <div class="container">
    <div class="available col">
      <h2>Available Units</h2>

      <?php
      foreach ( $data as $listings => $listing ) {
        $id = $listing->id;
        $unit = $listing->unit_number;
        $area = $listing->area;
        $updated = strtotime( $listing->updated_at );
        $updated_date = date( 'F j, Y', $updated );
        $updated_time = date( 'g:h a', $updated );

        if ( $area > 1 ) :
        ?>

          <div class="unit">
            <div class="image">
              <img src="/img/apartment_01.jpg" alt="Apartment kitchen" />
            </div>
            <div class="meta">
              <div class="meta-top">
                <h3>Unit: <?php echo $unit; ?></h3>
                <p>Area: <?php echo $area; ?> sq. ft.</p>
              </div>
              <p class="updated">Last updated: <?php echo $updated_date; ?> at <?php echo $updated_time; ?></p>
            </div>
          </div>
        <?php endif; ?>
      <?php } ?>
    </div>

    <div class="unavailable col">
      <h2>Unavailable Units</h2>

      <?php
      foreach ( $data as $listings => $listing ) {
        $id = $listing->id;
        $unit = $listing->unit_number;
        $area = $listing->area;
        $updated = strtotime( $listing->updated_at );
        $updated_date = date( 'F j, Y', $updated );
        $updated_time = date( 'g:h a', $updated );

        if ( $area == 1 ) :
        ?>

          <div class="unit">
            <div class="image">
              <img src="/img/apartment_01.jpg" alt="Apartment kitchen" />
            </div>
            <div class="meta">
              <div class="meta-top">
                <h3>Unit: <?php echo $unit; ?></h3>
                <p>Area: <?php echo $area; ?> sq. ft.</p>
              </div>
              <p class="updated">Last updated: <?php echo $updated_date; ?> at <?php echo $updated_time; ?></p>
            </div>
          </div>
        <?php endif; ?>
      <?php } ?>
    </div>
  </div>
</body>
</html>
