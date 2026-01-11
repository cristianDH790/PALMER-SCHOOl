<?php

namespace App\Controllers\Api\Auth;

use App\Entities\UsuarioEntity;
use App\Helpers\Util;
use App\Models\EstadoModel;
use App\Models\MensajeModel;

use App\Models\ParametroModel;
use App\Models\PerfilModel;

use App\Models\UsuarioModel;
use App\Transformadores\UsuarioTransformer;
use Firebase\JWT\JWT;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;

class AuthController extends ResourceController
{
    protected $usuario;
    protected $mensaje;
    protected $parametro;
    protected $estado;
    protected $perfil;
    private $email;
    protected $mailFromEmail;
    protected $mailFromName;
    public function __construct()
    {
        $this->usuario = new UsuarioModel();
        $this->mensaje = new MensajeModel();
        $this->parametro = new ParametroModel();
        $this->estado = new EstadoModel();
        $this->perfil = new PerfilModel();
        $this->email = Services::email();
    }
    public function login()
    {
        $username = $this->request->getVar('login');
        $password = $this->request->getVar('password');


        $user = $this->usuario->autenticar($username);
        if ($user &&  password_verify($password, $user->password)) {
            unset($user->password);

            $key = getenv('JWT_SECRET');

            $resultado = UsuarioTransformer::transform($user);

            $payload = [
                'sub' => $user->idusuario,
                'usuario' => $resultado,
                'iat' => time(), // Tiempo que se creo el token
                'nbf' => time(), // Tiempo que empieza a ser valido
                'exp' => time() + 3600, // Tiempo de expiracion
            ];

            $token = JWT::encode($payload, $key, 'HS256');

            return $this->respond([
                'status' => 'success',
                'token' => $token
            ], 200);
        } else {
            return $this->respond([
                'status' => 'error',
                'message' => 'Credenciales inválidas',
            ], 400);
        }
    }

    public function RecuperarClave()
    {
        helper('text');
        $correo = trim($this->request->getVar('correo'));

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return $this->respond([
                'status'  => 'error',
                'mensaje' => 'Correo electrónico inválido'
            ], 400);
        }

        $usuario = $this->usuario->obtenerPorEmail($correo);

        if (!$usuario) {
            return $this->respond([
                'status'  => 'error',
                'mensaje' => 'Correo no encontrado en el sistema'
            ], 404);
        }

        $util = new Util();
        $nuevaClave = $util::generatePassword(8);

        $hash = password_hash(trim($nuevaClave), PASSWORD_DEFAULT);

        $this->usuario->guardar([
            'idusuario' => $usuario->idusuario,
            'password'     => $hash,
            'idperfil'     => $usuario->idperfil,
        ]);

        $mensaje = $this->mensaje->obtenerPorId(12); // Plantilla de email
        if (!$mensaje) {
            return $this->respond([
                'status' => 'error',
                'mensaje' => 'Plantilla de mensaje no encontrada'
            ], 500);
        }

        // Personalizar contenido
        $contenido = $mensaje->contenido;

        $reemplazos = [
            '#1' => $usuario->nombres . " " . $usuario->papellido . " " . $usuario->sapellido,
            '#2' => $usuario->login,
            '#3' => $nuevaClave
        ];

        $contenidoFinal = strtr($contenido, $reemplazos);


        $this->email->setFrom(getenv('MAIL_FROM_EMAIL'), getenv('MAIL_FROM_NAME'));
        $this->email->setTo($correo);
        $this->email->setSubject($mensaje->asunto);
        $this->email->setMessage($contenidoFinal); // Si es HTML, puedes usar setMessage() con HTML MIME

        if ($this->email->send()) {
            return $this->respond([
                'status'  => 'success',
                'mensaje' => 'Correo enviado correctamente'
            ], 200);
        } else {
            log_message('error', print_r($this->email->printDebugger(['headers', 'subject', 'body']), true));
            return $this->respond([
                'status'  => 'error',
                'mensaje' => 'Error al enviar el correo'
            ], 500);
        }
    }
}
