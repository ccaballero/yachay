body {
    background-color: <?= $this->background ?>;
}

#header, #footer {
    background-color: <?= $this->background_headers ?>;
}

#header, #content h1, #content h2 {
    border-bottom-color: <?= $this->background_headers ?>;
}

#footer {
    border-top-color: <?= $this->background_headers ?>;
}

body {
    border-left-color: <?= $this->background_headers ?>;
    border-right-color: <?= $this->background_headers ?>;
}

#content h1, #content h2 {
    color: <?= $this->background_headers ?>;
}

#header *, #footer * {
    color: <?= $this->color_headers ?>;
}

#header > .tools .first {
    background-color: <?= $this->background_headers2 ?>;
    color: <?= $this->color_headers ?>;
}

#header a:focus, #footer a:focus {
    background-color: <?= $this->background_headers2 ?>;
}

#content a:focus img {
    background-color: <?= $this->background_headers2 ?>;
}

#primary #messages .message {
    background-color: <?= $this->background_messages ?>;
    border-color: <?= $this->color_borders ?>;
}

#content * {
    color: <?= $this->color_letters ?>;
}

#content #primary a {
    color: <?= $this->background_headers ?>;
}

#content #primary a:focus, #content #secondary a:focus {
    background-color: <?= $this->background_headers2 ?>;
    color: <?= $this->color_headers ?>;
}

#primary .resource .message {
    border-color: <?= $this->color_borders ?>;
}

#primary .resource .label {
    background-color: <?= $this->background_headers2 ?>;
    color: <?= $this->color_headers ?>;
}

#primary .resource .timestamp {
    background-color: <?= $this->color_borders ?>;
    color: <?= $this->background_headers2 ?>
}

#secondary .widget img {
    border-color: <?= $this->color_borders ?>;
}

#primary #main table {
    border-color: <?= $this->color_borders ?>;
}

#primary #main th {
    background-color: <?= $this->background_headers ?>;
    color: <?= $this->color_headers ?>;
}

#primary #main tr.odd {
    background-color: <?= $this->color_borders ?>;
}

#primary #main tr.even {
    background-color: <?= $this->color_headers ?>;
}

#primary .mark {
    background-color: <?= $this->background_headers2 ?>;
    color: <?= $this->color_headers ?>;
}

#primary .tag {
    border-color: <?= $this->background_headers ?>;
    background-color: <?= $this->color_borders ?>;
}

#primary .pagination span {
    background-color: <?= $this->background_headers ?>;
    color: <?= $this->color_headers ?>;
    border-color: <?= $this->background_headers ?>;
}

#primary #block .box {
    border-color: <?= $this->color_borders ?>;
}

#primary #block .import, #primary #block .member {
    border-color: <?= $this->color_borders ?>;
}

#primary #block .import .title, #primary #block .member .title {
    background-color: <?= $this->background_headers2 ?>;
    color: <?= $this->color_headers ?>;
}

#primary .message {
    border-color: <?= $this->color_borders ?>;
}

#content input, #content option, #content select {
    color: #000000;
}
