<?php
$nav = function ($title, $icon, $navItems) use ($app) {

    foreach ($navItems as $name => $url) {
        $active = ($app == $url ? " active" : null);
        $url = url("/admin/{$url}");
        $nav[] = "<a class=\"collapse-item{$active}\" href=\"{$url}\">{$name}</a>";
    }

    $id = ucfirst($title);
    $navItem = implode(null, $nav);

    $collapse = function ($if, $else) use ($app, $url) {
        return (explode("/", $app)[0] == explode("/", $url)[5] ? $if : $else);
    };

    return "<li class=\"nav-item{$collapse(" active", null)}\">
                <a class=\"nav-link {$collapse(" collapsed", null)}\" href=\"#\" 
                   data-toggle=\"collapse\" data-target=\"#collapse{$id}\" 
                   aria-expanded=\"{$collapse("true", "false")}\" aria-controls=\"collapse{$title}\">
                    <i class=\"{$icon}\"></i>
                    <span>{$id}</span>
                </a>
                <div id=\"collapse{$id}\" class=\"collapse{$collapse(" show", null)}\" aria-labelledby=\"heading" . ucfirst($title) . "\" data-parent=\"#accordionSidebar\">
                    <div class=\"bg-white py-2 collapse-inner rounded\">{$navItem}</div>
                </div>
            </li>";
};


// Usuários
echo $nav("Usuários", "fas fa-fw fa-user", [
    "Usuários" => "users/home",
    "Novo Usuário" => "users/user"
]);

// Control
echo $nav("Produtos", "fas fa-tshirt", [
    "Produtos" => "product/home",
    "Novo produto" => "product/product"
]);

// Usuários
echo $nav("Categorias", "far fa-folder", [
    "Categorias" => "category/home",
    "Nova Categoria" => "category/categories"
]);

echo $nav("Fabricantes", "fas fa-copyright", [
    "Fabricantes" => "brand/home",
    "Novo fabricante" => "brand/brands"
]);

//CONFIGURAÇÕES
echo $nav("Configurações", "fas fa-sliders-h", [
    "Configurações" => "settings/settings/1"
]);