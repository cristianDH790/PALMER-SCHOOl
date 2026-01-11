<?php

namespace App\Transformadores;

use App\Entities\UsuarioEntity;
use App\Models\EstadoModel;
use App\Models\ParametroModel;
use App\Models\PedidoModel;
use App\Models\PerfilModel;

class UsuarioTransformer
{
    public static function transform(UsuarioEntity $usuario)
    {
        // var_dump($usuario  );
        // die();
        return [
            'idUsuario' => (int) $usuario->idusuario,
            'idpDocumento' => (int)$usuario->idpdocumento,
            'documento' => $usuario->documento,
            'nombres'   => $usuario->nombres,
            'pApellido' => $usuario->papellido,
            'sApellido' => $usuario->sapellido,
            'fechaNacimiento' => $usuario->fechanacimiento,
            'sexo' => $usuario->sexo,
            'correo'    => $usuario->correo,
            'telefono'    => $usuario->telefono,
            'boletin'    => $usuario->boletin,
            'login'    => $usuario->login,
            // 'pedidos'    => ((new PedidoModel())->buscarPorTotal('', '', 329, $usuario->idusuario, 0, 0, 453, '')),
            'fecha'    => $usuario->fecha,
            // 'importeTotal'    => ((new PedidoModel())->pedidoTotalSumaUsuario('', '', 329, 453, $usuario->idusuario)),

            'perfil' => $usuario->idperfil ? PerfilTransformer::transform((new PerfilModel())->obtenerPorId($usuario->idperfil)) : null,
            'estado' => $usuario->idestado ? EstadoTransformer::transform((new EstadoModel())->obtenerPorId($usuario->idestado)) : null,
            'pDocumento' => $usuario->idpdocumento ? ParametroTransformer::transform((new ParametroModel())->obtenerPorId($usuario->idpdocumento)) : null,



        ];
    }
}
