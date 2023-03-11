<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cropper.js</title>
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@4/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.css"/>
  <style>
    .label {
      cursor: pointer;
    }

    .progress {
      display: none;
      margin-bottom: 1rem;
    }

    .alert {
      display: none;
    }

    .img-container img {
      max-width: 100%;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Upload cropped image to server</h1>

    <form action="simpan_pasien.php" method="post" enctype="multipart/form-data">
		<label for="name">Nama:</label>
		<input type="text" id="name" name="name"><br><br>

		<label for="date_of_birth">Tanggal Lahir:</label>
		<input type="date" id="date_of_birth" name="date_of_birth"><br><br>

		<label for="status">Status:</label>
		<select id="status" name="status">
			<option value="single">Single</option>
			<option value="married">Married</option>
		</select><br><br>

		<label for="nationality">Kewarganegaraan:</label>
		<input type="text" id="nationality" name="nationality"><br><br>

		<label for="district">Kecamatan:</label>
		<input type="text" id="district" name="district"><br><br>

		<label for="province">Provinsi:</label>
		<input type="text" id="province" name="province"><br><br>

		<label for="father_name">Nama Ayah:</label>
		<input type="text" id="father_name" name="father_name"><br><br>

		<label for="passport_no">Nomor Paspor:</label>
		<input type="text" id="passport_no" name="passport_no"><br><br>

        <label class="label" data-toggle="tooltip" title="Change your photo">
      <img class="rounded" id="photo" src="avatar.png" alt="photo">
      <input type="file" class="sr-only" id="input" name="image" accept="image/*">
    </label>

    <input type="submit" value="Kirim">
	</form>


    <div class="progress">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>

    <div class="alert" role="alert"></div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Crop the image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="crop">Crop</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://unpkg.com/jquery@3/dist/jquery.min.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/bootstrap@4/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.js"></script>

  <script>
    window.addEventListener('DOMContentLoaded', function () {
      var photo = document.getElementById('photo');
      var image = document.getElementById('image');
      var input = document.getElementById('input');
      var $progress = $('.progress');
      var $progressBar = $('.progress-bar');
      var $alert = $('.alert');
      var $modal = $('#modal');
      var cropper;

      $('[data-toggle="tooltip"]').tooltip();

      input.addEventListener('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
          input.value = '';
          image.src = url;
          $alert.hide();
          $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
          file = files[0];

          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }
      });

      $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
          aspectRatio: 3/4,
          viewMode: 3,
        });
      }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
      });

      document.getElementById('crop').addEventListener('click', function () {
        var initialPhotoURL;
        var canvas;

        $modal.modal('hide');

        if (cropper) {
          canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 400,
          });
          initialPhotoURL = photo.src;
          photo.src = canvas.toDataURL();
          $progress.show();
          $alert.removeClass('alert-success alert-warning');
          canvas.toBlob(function (blob) {
            var formData = new FormData();

            formData.append('photo', blob, 'photo.png');
            $.ajax('upload.php', {
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,

              xhr: function () {
                var xhr = new XMLHttpRequest();

                xhr.upload.onprogress = function (e) {
                  var percent = '0';
                  var percentage = '0%';

                  if (e.lengthComputable) {
                    percent = Math.round((e.loaded / e.total) * 100);
                    percentage = percent + '%';
                    $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                  }
                };

                return xhr;
              },

              success: function () {
                $alert.show().addClass('alert-success').text('Upload success');
              },

              error: function () {
                photo.src = initialPhotoURL;
                $alert.show().addClass('alert-warning').text('Upload error');
              },

              complete: function () {
                $progress.hide();
              },
            });
          });
        }
      });
    });
  </script>
</body>
</html>