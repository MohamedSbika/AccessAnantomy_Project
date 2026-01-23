<?php
// Vider le cache OPcache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "✅ Cache OPcache vidé avec succès !<br>";
} else {
    echo "❌ OPcache n'est pas activé.<br>";
}

// Vider le cache de réalisation
if (function_exists('apc_clear_cache')) {
    apc_clear_cache();
    echo "✅ Cache APC vidé avec succès !<br>";
}

echo "<br><strong>Tous les caches ont été vidés. Rechargez maintenant la page de votre livre.</strong><br>";
echo "<br><a href='FR/livre/70' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Retour au livre</a>";
?>
