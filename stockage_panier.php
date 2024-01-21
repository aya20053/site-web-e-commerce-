<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $panier = json_decode(file_get_contents("php://input"), true);

    // Stockez le panier dans la session
    $_SESSION['panier'] = $panier;

    // Répondez avec un message indiquant le succès
    echo json_encode(['message' => 'Panier stocké avec succès.']);
} else {
    // Répondez avec une erreur si la méthode de requête n'est pas POST
    http_response_code(400);
    echo json_encode(['error' => 'Méthode de requête non autorisée.']);
}
?>
