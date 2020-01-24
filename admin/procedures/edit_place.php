<?php
require_once '../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
//    $session->getFlashBag()->add('error', 'Sorry, access to the page you tried to visit is denied. Or is currently not available!');
//    header('location: index.php');
    echo "<h1 style='color: red'>ACCESS DENIED</h1>";
    exit;
}

$id = $_POST['id'];
$name = $_POST['name'];
$category = $_POST['category'];
$price = $_POST['price'];
$description = $_POST['description'];
$location = $_POST['location'];
$featured = $_POST['featured'];
$phone = $_POST['phone'];
$website = $_POST['website'];
$status = $_POST['status'];

$img = $_FILES['img']['name'];
$tmp = $_FILES['img']['tmp_name'];
$type = $_FILES['img']['type'];

$map_img = $_FILES['map']['name'];
$map_tmp = $_FILES['map']['tmp_name'];
$map_type = $_FILES['map']['type'];

if (!$name || !$category) {
//    $session->getFlashBag()->add('error', 'Please fill all the required fields');
//    header('location: campus_form.php');
    echo "<h1 style='color: brown'>Name of product is required. Please ensure these fields are filled.</h1>";
    exit;
}
if ($featured != 1) $featured = 0;

try {
    $place_id = updatePlace($id, $name, $category, $description, $price, $location, $phone, $website, $featured, $status);
    echo "<h1 style='color: green'>Successfully updated product. $place_id</h1>";
    if ($img) {
        $place = findPlaceById($id);
        if ($place['image'] && file_exists('../../' . $place['image'])) {
            if (unlink('../../' . $place['image'])) {
                $dir = "../../uploads/places/" . $place['id'] . "/img/";
                $real_path = "uploads/places/" . $place['id'] . "/img/" . time() . $img;
                $save_path = "../../" . $real_path;
                mkdir($dir, 0777, true);
                if (move_uploaded_file($tmp, $save_path)) {
                    try {
                        $stmt = $db->prepare("UPDATE places SET image = :path WHERE id = :place_id");
                        $stmt->bindParam(':path', $real_path);
                        $stmt->bindParam(':place_id', $id);
                        $stmt->execute();
                        echo "<h1 style='color: green'>Successfully uploaded image</h1>";
                    } catch (\Exception $e) {
                        throw $e;
                    }
                } else {
                    echo "<h1 style='color: red'>Error uploading image</h1>";
                    exit;
                }
            } else {
                echo "<h1 style='color: brown'>Error deleting current image ../" . $place['image'] . "</h1>";
            }
        } else {
            echo "<h1 style='color: brown'>Current image unavailable</h1>";
        }
    } else {
        echo "<h1 style='color: brown'>No image provided.</h1>";
    }

    if ($map_img) {
        $place = findPlaceById($id);
        if ($place['map'] && file_exists('../../' . $place['map'])) {
            if (unlink('../../' . $place['map'])) {
                $dir = "../../uploads/places/" . $place['id'] . "/map/";
                $real_path = "uploads/places/" . $place['id'] . "/map/" . time() . $map_img;
                $save_path = "../../" . $real_path;
                mkdir($dir, 0777, true);
                if (move_uploaded_file($map_tmp, $save_path)) {
                    try {
                        $stmt = $db->prepare("UPDATE places SET map = :path WHERE id = :place_id");
                        $stmt->bindParam(':path', $real_path);
                        $stmt->bindParam(':place_id', $id);
                        $stmt->execute();
                        echo "<h1 style='color: green'>Successfully uploaded map</h1>";
                    } catch (\Exception $e) {
                        throw $e;
                    }
                } else {
                    echo "<h1 style='color: red'>Error uploading map</h1>";
                    exit;
                }
            } else {
                echo "<h1 style='color: brown'>Error deleting current image ../" . $place['map'] . "</h1>";
            }
        } else {
            echo "<h1 style='color: brown'>Current map unavailable</h1>";
        }
    } else {
        echo "<h1 style='color: brown'>No map provided.</h1>";
    }
    exit;
//    $session->getFlashBag()->add('success', 'Successfully added new campus.');
//    header('location: campus_form.php');
} catch (\Exception $e) {
//    $session->getFlashBag()->add('error', "OOps, an error occurred while adding campus. {$e->getMessage()} Please try again or consult admin.");
//    header('location: campus_form.php');
    echo "<h1 style='color: red'>" . $e->getMessage() . "</h1>";
    exit;
}