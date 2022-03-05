<?php

namespace Model;

class Usuarios extends ActiveRecord{
    protected static $tabla = "usuario";
    protected static $columnasDB = ["id", "nombre", "email", "password", "token", "confirmado"];

    public function __construct($args = [])
    {
        $this->id = $args ["id"] ?? null;
        $this->nombre = $args ["nombre"] ?? null;
        $this->email = $args ["email"] ?? null;
        $this->password = $args ["password"] ?? null;
        $this->password2 = $args ["password2"] ?? null;
        $this->password_actual = $args ["password_actual"] ?? null;
        $this->password_nuevo = $args ["password_nuevo"] ?? null;
        $this->token = $args ["token"] ?? null;
        $this->confirmado = $args ["confirmado"] ?? null;
    }

    public function validarLogin()
    {
      if (!$this->email) {
         self::$alertas["error"][] ="el Email del Usuario es Obligatorio";
      }
      if (!$this->password) {
         self::$alertas["error"][] ="el Password del Usuario es Obligatorio";
      }
      if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
         self::$alertas["error"][] = "El Email no es valido";
       }

      return self::$alertas;
    }

    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
           self::$alertas["error"][] ="el Nombre del Usuario es Obligatorio";
        }
        if (!$this->email) {
           self::$alertas["error"][] ="el Email del Usuario es Obligatorio";
        }
        if (!$this->password) {
           self::$alertas["error"][] ="el Password del Usuario es Obligatorio";
        }
        if (strlen($this->password) < 6) {
           self::$alertas["error"][] ="el Password del Usuario debe contener minimo 6 cracteres";
        }
        if( $this->password !== $this->password2) {
           self::$alertas["error"][] ="Los Password debe ser igual en ambos campos";
        }

        return self::$alertas;
    }

    public function hashPassword() : void
    {
         $this->password = password_hash($this->password, PASSWORD_BCRYPT ); 
    }

    public function comprobar_password(string $password, string $password_Hash) : bool
    {
       return password_verify($password, $password_Hash);
    }

    public function token() : void
    {
       $this->token = md5(uniqid());
    }

    public function validarEmail()
    {
       if (!$this->email) {
          self::$alertas["error"][] = "El Email es Obligatorio";
       }

       if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
         self::$alertas["error"][] = "El Email no es valido";
       }
       

       return self::$alertas;
    }

    public function validarPassword() : array
    {
      if (!$this->password) {
         self::$alertas["error"][] ="el Password del Usuario es Obligatorio";
      }
      if (strlen($this->password) < 6) {
         self::$alertas["error"][] ="el Password del Usuario debe contener minimo 6 cracteres";
      }

      return self::$alertas;
    }

    public function validar_perfil() : array
    {
       if (!$this->nombre) {
          self::$alertas["error"][] = "El Nombre es Obligatorio";
       }

       if (!$this->email) {
          self::$alertas["error"][] = "El Email es Obligatorio";
       }

       return self::$alertas;
    }

    public function nuevo_password() : array
    {
       if (!$this->password_actual) {
          self::$alertas["error"][] = "El Password Actual no puede ir vacio";
       }

       if (!$this->password_nuevo) {
          self::$alertas["error"][] = "El Password Nuevo no puede ir vacio";
       }

       if (strlen($this->password_nuevo) < 6) {
          self::$alertas["error"][] = "El Password Nuevo debe ser minimo de 6 caracteres";
       }

       return self::$alertas;
    }

    
}