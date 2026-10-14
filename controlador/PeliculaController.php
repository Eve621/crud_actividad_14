<?php
require_once "modelo/Pelicula.php";
require_once "modelo/PeliculaDao.php";

class PeliculaController
{
    private $dao;

    // CONSTRUCTOR
    public function __construct($dao)
    {
        $this->dao = $dao;
    }

    // LISTAR
    public function index()
    {
        $peliculas = $this->dao->listar();
        require "vista/peliculas/index.php";
    }

    // NUEVO
    public function nuevo()
    {
        $pelicula = new Pelicula();
        require "vista/peliculas/formulario.php";
    }

    // GUARDAR
    public function guardar()
    {
        $pelicula = new Pelicula();
        $pelicula->setNombre($_POST["nombre"]);
        $pelicula->setGenero($this->generosDesdeFormulario());
        $pelicula->setDuracion($_POST["duracion"]);
        $pelicula->setImagenportada($_POST["imagenportada"]);
        $this->dao->insertar($pelicula);
        header("Location: index.php");
        exit;
    }

    // EDITAR
    public function editar()
    {
        $id = $_GET["id"];
        $pelicula = $this->dao->buscarPorId($id);
        require "vista/peliculas/formulario.php";
    }

    // ACTUALIZAR
    public function actualizar()
    {
        $pelicula = new Pelicula();
        $pelicula->setId($_POST["id"]);
        $pelicula->setNombre($_POST["nombre"]);
        $pelicula->setGenero($this->generosDesdeFormulario());
        $pelicula->setDuracion($_POST["duracion"]);
        $pelicula->setImagenportada($_POST["imagenportada"]);
        $this->dao->actualizar($pelicula);
        header("Location: index.php");
        exit;
    }

    // ELIMINAR
    public function eliminar()
    {
        $id = $_GET["id"];
        $this->dao->eliminar($id);
        header("Location: index.php");
        exit;
    }

    // GENEROS
    // Junta los géneros elegidos (máximo 3) en un solo texto: "Acción, Drama"
    private function generosDesdeFormulario()
    {
        $seleccion = $_POST["genero"] ?? [];
        if (!is_array($seleccion)) {
            $seleccion = [];
        }
        $seleccion = array_slice($seleccion, 0, 3);
        return mb_substr(implode(", ", $seleccion), 0, 50);
    }
}
