
<!doctype html>
<html lang="en">
<head>
	<style type="text/css">
		html {
		  font-size: 10px;
		  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
		}
		body {
		  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		  font-size: 14px;
		  line-height: 1.42857143;
		  color: #333333;
		  background-color: #ffffff;
		}
		a {
		  color: #337ab7;
		  text-decoration: none;
		}
		a:hover,
		a:focus {
		  color: #23527c;
		  text-decoration: none;
		}
		a:focus {
		  outline: 5px auto -webkit-focus-ring-color;
		  outline-offset: -2px;
		}
		.btn {
		  display: inline-block;
		  margin-bottom: 0;
		  font-weight: normal;
		  text-align: center;
		  white-space: nowrap;
		  vertical-align: middle;
		  -ms-touch-action: manipulation;
		  touch-action: manipulation;
		  cursor: pointer;
		  background-image: none;
		  border: 1px solid transparent;
		  padding: 6px 12px;
		  font-size: 14px;
		  line-height: 1.42857143;
		  border-radius: 4px;
		  -webkit-user-select: none;
		  -moz-user-select: none;
		  -ms-user-select: none;
		  user-select: none;
		}
		.btn-primary {
		  color: #ffffff;
		  background-color: #337ab7;
		  border-color: #2e6da4;
		}
		.btn-primary:hover {
		  color: #ffffff;
		  background-color: #286090;
		  border-color: #204d74;
		}
	</style>
</head>
<body>
	<h3>Halo, Kamu</h3>
	<p>Seseorang telah meminta kami untuk mereset password akun yang terdaftar pada email ini.  Namun jika kamu tidak memintanya, maka kamu dapat mengabaikan email ini :)</p>
	<a class="btn btn-primary" href="<?=base_url('lupa_password/new_password/').$token;?>">RESET PASSWORD</a>
	<p>Jika tombol diatas tidak berfungsi Anda dapat menyalin link dibawah ini ke peramban <br>
		<?=base_url('lupa_password')?>
	</p>

	<p>Terimakasih sudah menyempatkan waktu untuk membuka email kami, jika ada hal yang ingin ditanyakan silakan kirim email ke support@email.com</p>
	<p>Salam Hangat dari Kami</p>
</body>
</html>