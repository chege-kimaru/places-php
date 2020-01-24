<?php
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @return \Symfony\Component\HttpFoundation\Request
 */
function request()
{
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}

function redirect($path, $extra = [])
{
    $response = Response::create(null, Response::HTTP_FOUND, ['Location' => $path]);

    if (key_exists('cookies', $extra)) {
        foreach ($extra['cookies'] as $cookie) {
            $response->headers->setCookie($cookie);
        }
    }
    $response->send();
    exit;
}

function display_alerts($level, $messages = [])
{
    $response = '<div class="alert alert-' . $level . ' alert-dismissable">';
    foreach ($messages as $message) {
        $response .= "{$message}<br>";
    }
    $response .= '</div>';

    return $response;
}

function display_errors($bag = 'error')
{
    global $session;

    if (!$session->getFlashBag()->has($bag)) {
        return;
    }

    $messages = $session->getFlashBag()->get($bag);

    return display_alerts('danger', $messages);
}

function display_success($bag = 'success')
{
    global $session;

    if (!$session->getFlashBag()->has($bag)) {
        return;
    }

    $messages = $session->getFlashBag()->get($bag);

    return display_alerts('success', $messages);
}

//
function createPlace($name, $category, $description, $price, $location, $phone, $website, $featured, $status)
{
    global $db;

    try {
        $stmt = $db->prepare("INSERT INTO places (name, category, description, price, location, phone,
        website, featured, status) VALUES
        (:name, :category, :description, :price, :location, :phone, :website, :featured, :status)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':featured', $featured);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $db->lastInsertId();
    } catch (\Exception $e) {
        throw $e;
    }
}


function getAllPlacesInCategory($category)
{
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM places WHERE category = ?");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        throw $e;
    }
}

function getFeaturedPlaces()
{
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM places WHERE featured = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        throw $e;
    }
}


function findPlaceById($place_id)
{
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM places WHERE id = ?");
        $stmt->execute([$place_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        throw $e;
    }
}

function updatePlace($id, $name, $category, $description, $price, $location, $phone, $website, $featured, $status)
{
    global $db;

    try {
        $stmt = $db->prepare("UPDATE places SET name=:name, category=:category,  description=:description, price=:price, location=:location,
        phone=:phone, website=:website, featured=:featured, status=:status WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':featured', $featured);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $db->lastInsertId();
    } catch (\Exception $e) {
        throw $e;
    }
}

function searchPlace($name, $location, $category)
{
    $conn = new mysqli("localhost", "root", "kevinkimaru", "places");
    $terms = explode(" ", $name);
    if ($conn->connect_error) {
        die ("Oops connection Error: " . $conn->connect_error);
    }
    $query = "SELECT * FROM places WHERE ";
    $i = 0;
    foreach ($terms as $name) {
        $i++;
        if ($i == 1) {
            $query .= "(location LIKE '%$location%') AND (category LIKE '%$category%') AND (name LIKE '%$name%' ";
        } else {
            $query .= "OR name LIKE '%$name%' ";
        }
    }
    $query .= ");";
    $places = $conn->query($query);
    return $places;
}

function getPlaceImages($place_id)
{
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM place_images WHERE place_id = ?");
        $stmt->execute([$place_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        throw $e;
    }
}

function findPlaceImageById($place_image_id)
{
    global $db;

    try {
        $stmt = $db->prepare("SELECT * FROM place_images WHERE id = ?");
        $stmt->execute([$place_image_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        throw $e;
    }
}
