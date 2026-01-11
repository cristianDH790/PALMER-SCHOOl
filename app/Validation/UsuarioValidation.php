<?php

namespace App\Validation;

class UsuarioValidation
{
    public static function UsuarioGuardarValidation(array $data): array
    {
        $errors = [];

        if (empty($data['estado']['idEstado'])) {
            $errors[] = ["campo" => "estado", "valor" => "Seleccione el estado."];
        }

        if (empty($data['perfil']['idPerfil'])) {
            $errors[] = ["campo" => "perfil", "valor" => "Seleccione el rol."];
        }


        if (empty($data['pDocumento']['idParametro'])) {
            $errors[] = ["campo" => "pDocumento", "valor" => "Seleccione el documento."];
        }

        if (empty($data['login'])) {
            $errors[] = ["campo" => "login", "valor" => "Ingrese el login."];
        }

        if (empty($data['password'])) {
            $errors[] = ["campo" => "password", "valor" => "Ingrese la clave."];
        } elseif (strlen($data['password']) < 4) {
            $errors[] = ["campo" => "password", "valor" => "La clave debe tener al menos 6 caracteres."];
        }

        if (empty($data['nombres'])) {
            $errors[] = ["campo" => "nombres", "valor" => "Ingrese los nombres."];
        }

        if (empty($data['pApellido'])) {
            $errors[] = ["campo" => "papellido", "valor" => "Ingrese el primer apellido."];
        }

        if (empty($data['sApellido'])) {
            $errors[] = ["campo" => "sapellido", "valor" => "Ingrese el primer apellido."];
        }



        if (empty($data['documento'])) {
            $errors[] = ["campo" => "documento", "valor" => "Ingrese el docuemento."];
        }


        if (empty($data['sexo'])) {
            $errors[] = ["campo" => "sexo", "valor" => "Ingrese el sexo."];
        }


        if (empty($data['fechaNacimiento'])) {
            $errors[] = ["campo" => "fechanacimiento", "valor" => "Formato de fecha inválido."];
        }
        if (empty($data['password'])) {
            $errors[] = ["campo" => "password", "valor" => "Ingrese la clave."];
        }

        if (empty($data['correo'])) {
            $errors[] = ["campo" => "correo", "valor" => "Ingrese el correo."];
        } elseif (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = ["campo" => "correo", "valor" => "Correo electrónico inválido."];
        }


        return $errors;
    }

    public static function UsuarioActualizarValidation(array $data): array
    {
        $errors = [];


        if (empty($data['estado']['idEstado'])) {
            $errors[] = ["campo" => "estado", "valor" => "Seleccione el estado."];
        }

        if (empty($data['perfil']['idPerfil'])) {
            $errors[] = ["campo" => "perfil", "valor" => "Seleccione el rol."];
        }

        if (empty($data['pDocumento']['idParametro'])) {
            $errors[] = ["campo" => "pDocumento", "valor" => "Seleccione el documento."];
        }

        if (empty($data['login'])) {
            $errors[] = ["campo" => "login", "valor" => "Ingrese el login."];
        }



        if (empty($data['nombres'])) {
            $errors[] = ["campo" => "nombres", "valor" => "Ingrese los nombres."];
        }

        if (empty($data['pApellido'])) {
            $errors[] = ["campo" => "papellido", "valor" => "Ingrese el primer apellido."];
        }

        if (empty($data['sApellido'])) {
            $errors[] = ["campo" => "sapellido", "valor" => "Ingrese el primer apellido."];
        }


        if (empty($data['documento'])) {
            $errors[] = ["campo" => "documento", "valor" => "Ingrese el docuemento."];
        }


        if (empty($data['sexo'])) {
            $errors[] = ["campo" => "sexo", "valor" => "Ingrese el sexo."];
        }


        if (empty($data['fechaNacimiento'])) {
            $errors[] = ["campo" => "fechanacimiento", "valor" => "Formato de fecha inválido."];
        }

        if (empty($data['correo'])) {
            $errors[] = ["campo" => "correo", "valor" => "Ingrese el correo."];
        } elseif (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = ["campo" => "correo", "valor" => "Correo electrónico inválido."];
        }

        return $errors;
    }
}
