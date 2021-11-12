<div class="row">
  <div class="col-md-12">
    <div class="card">    
    <div class="card-header">
      <h3 class="card-title">Detail Presensi <strong><?php echo $data->name ?></strong></h3>
    </div>

    <div class="card-body">
      <div class="row">
        <?php if ($data->type == 2): ?>
        <div class="col-md-6">
          <div id="mapid" style="width: auto; height: 400px;"></div>
        </div>
        <?php endif ?>
        <div class="col-md-<?php echo ($data->type == 2) ? '6' : '12'; ?>">
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label>Tanggal</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                  </div>
                  <input type="text" class="form-control datepicker" name="date" value="<?php echo date('d-m-Y', strtotime($data->date)) ?>" required disabled>
                </div>
              </div>

              <div class="col-md-6">
                <label>Status</label>
                <input type="text" class="form-control" name="status" value="<?php echo $data->status ?>" required disabled>
              </div>
            </div>
          </div>
          <div class="form-group">                        
            <div class="row">
              <div class="col-md-6">
                <label>Jam Masuk</label>
                <div class="input-group" id="timepicker" data-target-input="nearest">
                  <div class="input-group-prepend" data-target="#timepicker" data-toggle="datetimepicker">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" name="checkin" class="form-control datetimepicker-input" data-target="#timepicker" data-toggle="datetimepicker" value="<?php echo date('H:i:s', strtotime($data->checkin)) ?>" required disabled>
                </div>
              </div>
              <div class="col-md-6">                          
                <label>Jam Pulang</label>
                <div class="input-group" id="timepicker2" data-target-input="nearest">
                  <div class="input-group-prepend" data-target="#timepicker2" data-toggle="datetimepicker">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" name="checkout" class="form-control datetimepicker-input" data-target="#timepicker2" data-toggle="datetimepicker" value="<?php echo date('H:i:s', strtotime($data->checkout)) ?>" required disabled>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <input type="text" class="form-control" name="notes" value="<?php echo $data->notes ?>" required disabled>
          </div>
          <div class="form-group">
            <label>Tipe</label>
            <input type="text" class="form-control" name="type" value="<?php echo $data->type_presence ?>" required disabled>
          </div>

          <?php if ($data->type == 2): ?>                        
          <div class="form-group clearfix">
            <label>Kondisi Kesehatan</label>
            <input type="text" class="form-control" name="condition" value="<?php echo $data->condition ?>" required disabled>
          </div>
          <div class="form-group">
            <label>Kota Absen</label>
            <input type="text" class="form-control" name="city" value="<?php echo $data->city ?>" required disabled>
          </div>                      
          <div class="form-group">
            <label>Keluhan Kesehatan (Optional)</label>
            <input type="text" class="form-control" name="health_records" value="<?php echo $data->health_records ?>" required disabled>
          </div>
          <?php endif ?>
        </div>
      </div>
    </div>

    <div class="card-footer">
      <div class="float-right"> 
          <?php if (isset($_GET['group']) && isset($_GET['nip']) && isset($_GET['type']) && isset($_GET['date'])): ?>
            <a class="btn btn-default" href="<?php echo base_url() ?>hrd/presence<?php echo '?group='.$_GET['group'].'&nip='.$_GET['nip'].'&type='.$_GET['type'].'&date='.$_GET['date'] ?>"><span class="fa fa-reply"></span>&nbsp;&nbsp; Kembali</a>
          <?php else : ?>
            <a class="btn btn-default" href="<?php echo base_url() ?>hrd/presence"><span class="fa fa-reply"></span>&nbsp;&nbsp; Kembali</a>  
          <?php endif ?>
              
            <a class="btn btn-primary" href="<?php echo base_url() ?>hrd/presence/edit/<?php echo $data->id ?>"><span class="fa fa-edit"></span>&nbsp;&nbsp; Ubah</a>
        </div>
    </div>
  </div>
  </div>
</div>

<script>
lat_checkin = '<?php echo $data->lat_checkin; ?>';
long_checkin = '<?php echo $data->long_checkin; ?>';
lat_checkout = '<?php echo $data->lat_checkout; ?>';
long_checkout = '<?php echo $data->long_checkout; ?>';

latitude = '<?php echo $data->lat_city; ?>';
longtitude = '<?php echo $data->long_city; ?>';

function initialize() {
  var latlng = {lat: -6.262581048548821, lng: 106.86614602804184};
  var geocoder = new google.maps.Geocoder;
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === 'OK') {
    if (results[0]) {
      rs = results[0].formatted_address;
    } else {
      rs = 'No results found';
    }
    } else {
      rs = 'Geocoder failed due to: ' + status;
    }
     alert(rs);
  });
}

// google.maps.event.addDomListener(window, 'load', initialize);

var mymap = L.map('mapid').setView([latitude, longtitude], 9.19);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
  maxZoom: 18,
  attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>, ' +
    'Modified © <a href="https://burhanmafazi.xyz">Burhan Mafazi</a>',
  id: 'mapbox/streets-v11',
  // id: 'mapbox/satellite-v9',
  tileSize: 512,
  zoomOffset: -1
}).addTo(mymap);

var name = '<?php echo $data->name ?>';

var marker = L.marker([latitude, longtitude]).addTo(mymap);

marker.bindPopup("<b>" + name +"</b><br>absen dari kota ini").openPopup();

if (lat_checkin == lat_checkout && long_checkin == long_checkin) {
  var marker2 = L.marker([lat_checkin, long_checkin]).addTo(mymap);

  marker2.bindPopup("<b>" + name +"</b><br>datang dan pulang dari sini").openPopup();
} else {
  var marker2 = L.marker([lat_checkin, long_checkin]).addTo(mymap);

  marker2.bindPopup("<b>" + name +"</b><br>datang dari sini").openPopup();
  if (lat_checkout == "" && long_checkin == "") {
    var marker3 = L.marker([lat_checkin, long_checkin]).addTo(mymap);

    marker3.bindPopup("<b>" + name +"</b><br>datang dan pulang dari sini").openPopup();
  } else {
    var marker3 = L.marker([lat_checkout, long_checkin]).addTo(mymap);

    marker3.bindPopup("<b>" + name +"</b><br>pulang dari sini").openPopup();
  }
}

var popup = L.popup();

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(mymap);
}

mymap.on('click', onMapClick);
</script>