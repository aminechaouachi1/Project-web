<?php
include 'components/connect.php';

// Assume you have a type_id passed through the URL
if (isset($_GET['type_id'])) {
    $type_id = $_GET['type_id'];
    
    // Delete the type from the database
    $delete_type = $conn->prepare("DELETE FROM `types` WHERE id = ?");
    $delete_type->execute([$type_id]);

    $success_msg[] = 'Product type deleted!';
}
?>
<!-- Redirect to indexType.php or another appropriate page -->
<script>
    window.location.href = 'indexType.php';
</script>
