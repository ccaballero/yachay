<div>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th>UN</th>
            <th>EM</th>
            <th>AC</th>
            <th>PA</th>
            <th>PO</th>
            <th>SO</th>
        <?php foreach ($this->stat['users'] as $_to => $user) { ?>
            <th>&nbsp;</th>
        <?php } ?>
        </tr>
    <?php foreach ($this->stat['users'] as $_from => $user) { ?>
        <tr>
            <th><?php echo $user['role'] ?></th>
            <td class="center bool <?php echo !empty($user['username']) ? 'res_yellow':'' ?>"><?php echo !empty($user['username']) ? 'X':'&nbsp;' ?></td>
            <td class="center bool <?php echo !empty($user['email']) ? 'res_yellow':'' ?>"><?php echo !empty($user['email']) ? 'X':'&nbsp;' ?></td>
            <td class="center num <?php echo $user['ac'] <> 0 ? 'res_yellow':'' ?>"><?php echo $user['ac'] ?></td>
            <td class="center num <?php echo $user['pa'] <> 0 ? 'res_yellow':'' ?>"><?php echo $user['pa'] ?></td>
            <td class="center num <?php echo $user['po'] <> 0 ? 'res_yellow':'' ?>"><?php echo $user['po'] ?></td>
            <td class="center num <?php echo $user['so'] <> 0 ? 'res_yellow':'' ?>"><?php echo $user['so'] ?></td>
        <?php foreach ($this->stat['users'] as $_to => $user) { ?>
            <?php if ($_from == $_to) { ?>
                <td style="background-color: <?php echo $this->fg ?>">&nbsp;</td>
            <?php } else { ?>
                <?php $el = $this->stat['matrix'][$_from][$_to] ?>
                <?php if ($el <> null) { ?>
                    <td class="center <?php echo $el['mutual'] ? 'mutual':'uni' ?>">X</td>
                <?php } else { ?>
                    <td class="center">&nbsp;</td>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        </tr>
    <?php } ?>
    </table>
</div>
