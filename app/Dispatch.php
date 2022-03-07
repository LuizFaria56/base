<?php

namespace App;

use Src\Classes\Route;
use Src\Classes\Util;

/**
 * Com base na URL determina: Objeto, Metodo e Parametros; e invoca a funcao
 */
class Dispatch extends Route
{
   
   # atributos
   private $Method;
   private $Param = array();
   private $Obj;
   private $DefaultMethod;
   private $Url = array();

   # metodos getters e setters
   protected function getMethod() { return $this->Method; }
   public function setMethod($Method) { $this->Method = $Method; }
   protected function getParam() { return $this->Param; }
   public function setParam($Param) { $this->Param = $Param; }
   protected function getDefaultMethod() { return $this->DefaultMethod; }
   public function setDefaultMethod($DefaultMethod) { $this->DefaultMethod = $DefaultMethod; }
   protected function getUrl() { return $this->Url; }
   public function setUrl($Url) { $this->$Url = $Url; }

   # +-----------------------------------------------------------------------+
   # | metodo construtor: obtem URL e passa ao metodo addController          |
   # +-----------------------------------------------------------------------+
   public function __construct()
   {
      $this->setDefaultMethod('iniciar');
      $this->Url = Util::urlParse();
      $this->addController();
      # invoca funcao do objeto instanciado passando parametros
      call_user_func_array([$this->Obj, $this->getMethod()], $this->getParam());
   }
   
   # +-----------------------------------------------------------------------+
   # | identifica e instancia objeto controller e passa ao metodo addMethod  |
   # +-----------------------------------------------------------------------+
   private function addController()
   {
      $rotaController = $this->getRota();
      $nameSpace = "App\\Controller\\{$rotaController}";
      $this->Obj = new $nameSpace;
      if(isset($this->getUrl()[1])) {
         $this->addMethod();
      } else {
         # se nao informar o metodo, utiliza o default
         $this->setMethod($this->DefaultMethod);
      }
   }

   # +-----------------------------------------------------------------------+
   # | identifica o metodo e passa ao metodo addParam                        |
   # +-----------------------------------------------------------------------+
   private function addMethod()
   {
      if(method_exists($this->Obj, $this->getUrl()[1])) {
         $this->setMethod("{$this->getUrl()[1]}");
         $this->addParam();
      } else {
         # se o metodo informado nao existe, utiliza o metodo default
         $this->setMethod($this->DefaultMethod);
      }
   }

   # +-----------------------------------------------------------------------+
   # | identifica parametros (retorna ao __construct)                        |
   # +-----------------------------------------------------------------------+
   private function addParam()
   {
      $contArray = count($this->getUrl());
      if($contArray > 2) {
         foreach ($this->getUrl() as $key => $value) {
            if ($key > 1) {
               $this->setParam($this->Param += [$key => $value]);
            }
         }
      }
   }

}
