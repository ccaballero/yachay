body {
    background-color: <?php echo $this->background ?>;
}

#header, #footer {
    background-color: <?php echo $this->background_headers ?>;
}

#header, #content h1, #content h2 {
    border-bottom-color: <?php echo $this->background_headers ?>;
}

#header {
    background-image: url('<?php echo $this->config->wwwroot ?>media/yachay.png');
    background-repeat: no-repeat;
}

#footer {
    border-top-color: <?php echo $this->background_headers ?>;
}

body {
    border-left-color: <?php echo $this->background_headers ?>;
    border-right-color: <?php echo $this->background_headers ?>;
}

#content h1, #content h2 {
    color: <?php echo $this->background_headers ?>;
}

#header, #footer, #header a, #footer a {
    color: <?php echo $this->color_headers ?>;
}

#header > .tools .first {
    background-color: <?php echo $this->background_headers2 ?>;
    color: <?php echo $this->color_headers ?>;
}

#header a:focus, #footer a:focus {
    background-color: <?php echo $this->background_headers2 ?>;
}

#content a:focus img {
    background-color: <?php echo $this->background_headers2 ?>;
}

#primary #messages .message {
    background-color: <?php echo $this->background_messages ?>;
    border-color: <?php echo $this->color_borders ?>;
}

#content * {
    color: <?php echo $this->color_letters ?>;
}

#content #primary a {
    color: <?php echo $this->background_headers ?>;
}

#content #primary a:focus, #content #secondary a:focus {
    background-color: <?php echo $this->background_headers2 ?>;
    color: <?php echo $this->color_headers ?>;
}

#primary .resource .message {
    border-color: <?php echo $this->color_borders ?>;
}

#primary .resource .message a {
    border-color: <?php echo $this->color_borders ?>;
}

#primary .resource .label {
    background-color: <?php echo $this->background_headers2 ?>;
    color: <?php echo $this->color_headers ?>;
}

#primary .resource .timestamp {
    background-color: <?php echo $this->color_borders ?>;
    color: <?php echo $this->background_headers2 ?>
}

#secondary .widget img {
    border-color: <?php echo $this->color_borders ?>;
}

#primary #main table {
    border-color: <?php echo $this->color_borders ?>;
}

#primary #main th {
    background-color: <?php echo $this->background_headers ?>;
    color: <?php echo $this->color_headers ?>;
}

#primary #main tr.odd {
    background-color: <?php echo $this->color_borders ?>;
}

#primary #main tr.even {
    background-color: <?php echo $this->color_headers ?>;
}

#primary .mark {
    background-color: <?php echo $this->background_headers2 ?>;
    color: <?php echo $this->color_headers ?>;
}

#primary .tag {
    border-color: <?php echo $this->background_headers ?>;
    background-color: <?php echo $this->color_borders ?>;
}

#primary .pagination span {
    background-color: <?php echo $this->background_headers ?>;
    color: <?php echo $this->color_headers ?>;
    border-color: <?php echo $this->background_headers ?>;
}

#primary #block .box {
    border-color: <?php echo $this->color_borders ?>;
}

#primary #block .import, #primary #block .member {
    border-color: <?php echo $this->color_borders ?>;
}

#primary #block .import .title, #primary #block .member .title {
    background-color: <?php echo $this->background_headers2 ?>;
    color: <?php echo $this->color_headers ?>;
}

#primary .message {
    border-color: <?php echo $this->color_borders ?>;
}

#content input, #content option, #content select, #content textarea {
    color: #000000;
}

#primary .tabs.top {
    border-bottom-color: <?php echo $this->color_borders ?>;
}

#primary .tabs.bottom {
    border-top-color: <?php echo $this->color_borders ?>;
}

#primary .tabs a {
    border-color: <?php echo $this->color_borders ?>;
}

#primary .tabs a.active {
    background-color: <?php echo $this->color_borders ?>;
}
