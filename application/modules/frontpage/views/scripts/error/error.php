<div id="full">
    <h1><?php echo $this->message ?></h1>

    <?php if (isset($this->exception)) { ?>
        <h2>Exception information:</h2>
        <p><?php echo $this->exception->getMessage() ?></p>

        <h3>Stack trace:</h3>
        <pre><?php echo $this->exception->getTraceAsString() ?></pre>

        <h3>Request Parameters:</h3>
        <pre><?php echo var_export($this->request->getParams(), true) ?></pre>
    <?php } ?>
</div>
