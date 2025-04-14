<?php
// public function changePassword($oldPassword, $newPassword) {
//     session_start();
//     if (isset($_SESSION['user_id'])) {
//         $userId = $_SESSION['user_id'];
//         $query = "SELECT password FROM users WHERE id = ?";
//         $stmt = $this->db->prepare($query);
//         $stmt->bind_param('i', $userId);
//         $stmt->execute();
//         $result = $stmt->get_result()->fetch_assoc();

//         if ($result && password_verify($oldPassword, $result['password'])) {
//             $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
//             $query = "UPDATE users SET password = ? WHERE id = ?";
//             $stmt = $this->db->prepare($query);
//             $stmt->bind_param('si', $hashedPassword, $userId);
//             $stmt->execute();
//             return true;
//         }
//     }
//     return false;
// }
?>