<?php
require_once "modelo/Pelicula.php";

class PeliculaDao
{
    private $conexion;

    // CONSTRUCTOR
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // LISTAR PELICULAS
    public function listar()
    {
        $sql = "SELECT id, nombre, genero, duracion, imagenportada
                FROM pelicula
                ORDER BY id DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $peliculas = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pelicula = new Pelicula(
                $fila["id"],
                $fila["nombre"],
                $fila["genero"],
                $fila["duracion"],
                $fila["imagenportada"]
            );
            $peliculas[] = $pelicula;
        }
        return $peliculas;
    }

    // BUSCAR POR ID
    public function buscarPorId($id)
    {
        $sql = "SELECT id, nombre, genero, duracion, imagenportada
                FROM pelicula
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(["id" => $id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            return new Pelicula(
                $fila["id"],
                $fila["nombre"],
                $fila["genero"],
                $fila["duracion"],
                $fila["imagenportada"]
            );
        }
        return null;
    }

    // INSERTAR
    public function insertar(Pelicula $pelicula)
    {
        $sql = "INSERT INTO pelicula
                (nombre, genero, duracion, imagenportada)
                VALUES
                (:nombre, :genero, :duracion, :imagenportada)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            "nombre"        => $pelicula->getNombre(),
            "genero"        => $pelicula->getGenero(),
            "duracion"      => $pelicula->getDuracion(),
            "imagenportada" => $pelicula->getImagenportada()
        ]);
    }

    // ACTUALIZAR
    public function actualizar(Pelicula $pelicula)
    {
        $sql = "UPDATE pelicula
                SET nombre = :nombre,
                    genero = :genero,
                    duracion = :duracion,
                    imagenportada = :imagenportada
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            "id"            => $pelicula->getId(),
            "nombre"        => $pelicula->getNombre(),
            "genero"        => $pelicula->getGenero(),
            "duracion"      => $pelicula->getDuracion(),
            "imagenportada" => $pelicula->getImagenportada()
        ]);
    }

    // ELIMINAR
    public function eliminar($id)
    {
        $sql = "DELETE FROM pelicula
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute(["id" => $id]);
    }
}
