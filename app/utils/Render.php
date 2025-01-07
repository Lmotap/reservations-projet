<?php

/**
 * Trait permettant de rendre une vue avec un layout.
 */
trait Render
{
    /**
     * Rend une vue spécifiée avec un layout donné.
     * 
     * @param string $view Nom de la vue à rendre (sans extension).
     * @param array $data Données à passer à la vue sous forme de tableau associatif.
     * @param string $layout Nom du layout à utiliser (par défaut : 'main').
     * 
     * @throws Exception Si la vue ou le layout spécifié n'existe pas.
     * @return void
     */
    public function renderView(string $view, array $data = [], string $layout = 'main')
    {
        // Extraire les données pour les rendre disponibles en tant que variables dans la vue
        extract($data);

        // Déterminer le chemin racine du projet
        $rootPath = dirname(dirname(__DIR__)); // Remonte de deux niveaux depuis /app/utils/

        // Déterminer le chemin complet de la vue
        $viewPath = $rootPath . '/app/views/' . $view . '.php';

        if (file_exists($viewPath)) {
            // Démarrer la mise en tampon de sortie pour capturer le contenu de la vue
            ob_start();
            // Inclure la vue
            require_once $viewPath;
            // Récupérer le contenu de la vue et nettoyer le tampon
            $content = ob_get_clean();

            // Déterminer le chemin complet du layout
            $layoutPath = $rootPath . '/app/views/layouts/' . $layout . '.php';

            // Vérifier si le fichier du layout existe
            if (!file_exists($layoutPath)) {
                throw new Exception("Layout {$layout} introuvable à l'emplacement : {$layoutPath}");
            }

            // Démarrer un nouveau tampon de sortie pour le layout
            ob_start();
            // Inclure le layout
            require_once $layoutPath;
            // Afficher le contenu final rendu
            echo ob_get_clean();
        } else {
            throw new Exception("Vue {$view} introuvable à l'emplacement : {$viewPath}");
        }
    }
}
