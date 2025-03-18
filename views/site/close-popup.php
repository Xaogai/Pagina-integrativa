<?php
use yii\helpers\Url;
?>
<script type="text/javascript">
    // Cerrar la ventana emergente
    window.opener.location.href = "<?= Url::to(['/alumno']) ?>"; // Redirigir a la página principal
    window.close(); // Cerrar la ventana emergente
</script>