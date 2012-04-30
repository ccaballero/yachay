<h1>Peticiones: <?php echo $this->community->label ?></h1>

<form method="post" action="" accept-charset="utf-8">
    <input type="hidden" name="return" value="<?php echo $this->currentPage() ?>" />

    <div>
<?php if ($this->community->amModerator()) { ?><input type="submit" value="Aceptar Petición" name="accept" /><input type="submit" value="Denegar Petición" name="decline" /><?php } ?>
    </div>

<div id="block">
<?php if (count($this->applicants) != 0) { ?>
    <?php foreach ($this->applicants as $applicant) { ?>
        <?php $assign = $this->community->getPetition($applicant); ?>
        <div class="member">
            <?php if ($this->community->amModerator()) { ?>
                <input type="checkbox" name="applicants[]" value="<?php echo $applicant->ident ?>" />
            <?php } ?>
                <p><span class="title"><?php echo $applicant->getFullName() ?></span></p>
            <?php if ($this->acl('users', 'view')) { ?>
                <a href="<?php echo $this->url(array('user' => $applicant->url), 'users_user_view') ?>"><img class="photo" src="<?php echo $this->config->resources->frontController->baseUrl . '/media/users/thumbnail_small/' . $applicant->getAvatar() ?>" alt="<?php echo $applicant->getFullName() ?>" title="<?php echo $applicant->getFullName() ?>" /></a>
            <?php } else { ?>
                <img class="photo" src="<?php echo $this->config->resources->frontController->baseUrl . '/media/users/thumbnail_medium/' . $applicant->getAvatar() ?>" alt="<?php echo $applicant->getFullName() ?>" title="<?php echo $applicant->getFullName() ?>" />
            <?php } ?>
            <div class="body">
            <?php if ($this->community->amModerator()) { ?>
                <a href="<?php echo $this->url(array('community' => $this->community->url, 'user' => $applicant->url), 'communities_community_petition_applicant_accept') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/group_add.png' ?>" alt="Aceptar" title="Aceptar" /></a>
                <a href="<?php echo $this->url(array('community' => $this->community->url, 'user' => $applicant->url), 'communities_community_petition_applicant_decline') ?>"><img src="<?php echo $this->TEMPLATE->htmlbase . 'images/group_delete.png' ?>" alt="Denegar" title="Denegar" /></a>
            <?php } ?>
                <p><span class="bold">Fecha solicitud: </span></p>
                <p><?php echo $this->timestamp($assign->tsregister) ?></p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <p>No existe ninguna petición de ingreso en esta comunidad.</p>
<?php } ?>
    <div class="clear"></div>
</div>

    <div>
<?php if ($this->community->amModerator()) { ?><input type="submit" value="Aceptar Petición" name="accept" /><input type="submit" value="Denegar Petición" name="decline" /><?php } ?>
    </div>
</form>
