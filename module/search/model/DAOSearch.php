<?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/Fashe/';
	include($path . "model/connect.php");

class DAO_search {
    function buscar_marca(){
        $select="SELECT * FROM marcas";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }


    function buscar_categoria(){
        $select="SELECT * FROM `categorias`";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }


/*     SELECT DISTINCT ciu.*
FROM ciudades ciu
INNER JOIN accesorios acc ON ciu.id_ciudad = acc.id_ciudad
INNER JOIN categorias cat ON acc.id_categoria = cat.id_categoria
INNER JOIN marcas mar ON acc.id_marca = mar.id_marca
WHERE cat.name = 'Mochilas' AND mar.name = 'Nike'; */

    function buscar_marca_por_categoria ($category){
        $select="SELECT DISTINCT m.*
        FROM marcas m
        INNER JOIN accesorios a ON m.id_marca = a.id_marca
        INNER JOIN categorias c ON a.id_categoria = c.id_categoria
        WHERE c.name = '$category';";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }




    function buscar_ciudad_por_marca_y_caregoria ($category, $marca, $complete){
        $select=" SELECT DISTINCT ciu.*
        FROM ciudades ciu
        INNER JOIN accesorios acc ON ciu.id_ciudad = acc.id_ciudad
        INNER JOIN categorias cat ON acc.id_categoria = cat.id_categoria
        INNER JOIN marcas mar ON acc.id_marca = mar.id_marca
        WHERE cat.name = '$category' AND mar.name = '$marca' AND ciu.name LIKE '$complete%';";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }


    function buscar_ciudad_por_marca ($marca, $complete){
        $select=" SELECT DISTINCT ciu.*
        FROM ciudades ciu
        INNER JOIN accesorios acc ON ciu.id_ciudad = acc.id_ciudad
        INNER JOIN categorias cat ON acc.id_categoria = cat.id_categoria
        INNER JOIN marcas mar ON acc.id_marca = mar.id_marca
        WHERE mar.name = '$marca' AND ciu.name LIKE '$complete%';";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }



    function buscar_ciudad_por_categoria ($category, $complete){
        $select=" SELECT DISTINCT ciu.*
        FROM ciudades ciu
        INNER JOIN accesorios acc ON ciu.id_ciudad = acc.id_ciudad
        INNER JOIN categorias cat ON acc.id_categoria = cat.id_categoria
        INNER JOIN marcas mar ON acc.id_marca = mar.id_marca
        WHERE cat.name = '$category' AND ciu.name LIKE '$complete%';";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }


    function search_category_null(){
        $select="SELECT DISTINCT * FROM categoria";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }

    function search_category($brand){
        $select="SELECT ca.*
        FROM car c, categoria ca
        WHERE ca.id_categoria = c.categoria AND c.marca = '$brand'";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);

        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }

    function select_only_brand($complete, $brand){
        $select="SELECT *
        FROM car c
        WHERE marca = '$brand' AND city LIKE '$complete%'";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }

    function select_only_category($category, $complete){
        $select="SELECT *
        FROM car c
        WHERE categoria = '$category' AND city LIKE '$complete%'";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }


    function select_brand_category($complete, $brand, $category){
        $select="SELECT *
        FROM car c
        WHERE c.marca = '$brand' AND c.categoria = '$category' AND c.city LIKE '$complete%'";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }

    function select_city($complete){
        $select="SELECT *
        FROM car c
        WHERE c.city LIKE '$complete%'";
        
        $conexion = connect::con();
        $res = mysqli_query($conexion, $select);
        connect::close($conexion);
        
        $retrArray = array();
        if ($res -> num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }
        }
        return $retrArray;
    }
}