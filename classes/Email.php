<?php
require_once __DIR__ . "/../model/Model.php";
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/Global.php";

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
  public $email;
  public $mail;

  public function __construct($email)
  {
    $this->email = $email;
    $this->mail = new PHPMailer(true);
    $this->mail->isSMTP();
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->SMTPAuth = true;
    $this->mail->Username = $_ENV['EMAIL'];
    $this->mail->Password = $_ENV['PASSWORD_EMAIL'];
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $this->mail->Port = 465;
    $this->mail->setFrom($_ENV['EMAIL']);
  }

  public function existeEmail()
  {
    $model = new Model();
    return $model->seleccionaRegistros("administradores", ["email"], "email='$this->email'")
      || $model->seleccionaRegistros("empleados", ["email"], "email='$this->email'")
      || $model->seleccionaRegistros("clientes", ["email"], "email='$this->email'");
  }

  public function enviarCodigo($caso = "creacion_cuenta")
  {
    $numeroAleatorio = rand(10000, 99999);
    try {
      ob_start();
      $this->mail->addAddress($this->email);
      $this->mail->Subject = $caso === "creacion_cuenta"
        ? 'Código para creación de cuenta en GomiBike'
        : "Código para recuperación de contraseña en GomiBike";
      $this->mail->CharSet = 'UTF-8';
      $this->mail->isHTML(true);

      // Lee el CSS como string
      $css = file_get_contents(__DIR__ . "/../css/envio_codigo_email.css");

      // Carga el contenido específico
      if ($caso === "creacion_cuenta") {
        ob_start();
        include __DIR__ . "/../view/cliente/codigo_creacion_cuenta_email.php";
        $content = ob_get_clean();
      } else {
        ob_start();
        include __DIR__ . "/../view/codigo_recuperar_password.php";
        $content = ob_get_clean();
      }

      // Incluye el master, que debe usar $css y $content
      include __DIR__ . "/../view/master_emails.php";
      $html = ob_get_clean();

      $this->mail->Body = $html;
      $this->mail->send();
    } catch (Exception $e) {
      echo "No se puede enviar el correo. Error: {$this->mail->ErrorInfo}";
      file_put_contents(__DIR__ . '/../logs/PHPMailer_error.log', date('c') . " - Error: " . $e->getMessage() . "\n", FILE_APPEND);
      return null;
    }
    return $numeroAleatorio;
  }

  public function notificarVenta($id_venta)
  {
    try {
      $model = new Model();
      $ticket = $model->seleccionaRegistros(
        "ventas",
        [
          "detalle_venta.id_venta",
          "productos.foto_path",
          "productos.nombre",
          "detalle_venta.cantidad",
          "detalle_venta.importe"
        ],
        "ventas.id_venta = $id_venta",
        null,
        "INNER JOIN detalle_venta ON ventas.id_venta = detalle_venta.id_venta
        INNER JOIN productos ON detalle_venta.id_producto = productos.id_producto"
      );
      ob_start();
      $this->mail->addAddress($this->email);
      $this->mail->Subject = "Venta $id_venta creada exitosamente - GomiBike";
      $this->mail->CharSet = 'UTF-8';
      $this->mail->isHTML(true);
      foreach ($ticket as $k => $item) {
        $cid = 'img' . $item['id_venta'] . '_' . $k;
        $foto_path = $item['foto_path'];
        $this->mail->AddEmbeddedImage(str_replace(SITE_URL, __DIR__ . "/../", $foto_path), $cid);
        $ticket[$k]['cid'] = $cid;
      }

      $css = file_get_contents(__DIR__ . "/../css/cliente/email_venta.css");
      ob_start();
      include __DIR__ . "/../view/cliente/email_venta.php";
      $content = ob_get_clean();

      include __DIR__ . "/../view/master_emails.php";
      $html = ob_get_clean();

      $this->mail->Body = $html;
      $this->mail->send();
    } catch (Exception $e) {
      echo "No se puede enviar el correo. Error: {$this->mail->ErrorInfo}";
      file_put_contents(__DIR__ . '/../logs/PHPMailer_error.log', date('c') . " - Error: " . $e->getMessage() . "\n", FILE_APPEND);
    }
  }
}
