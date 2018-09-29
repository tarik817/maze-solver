<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Maze</title>
        <style>
            input, form {
                margin: 0;
                padding: 0;
            }

            input {
                cursor: pointer;
            }

            .row {
                display: flex;
            }

            .cell {
                width: 35px;
                height: 35px;
            }

            form, .cell {
                border: .5px solid lightgray;
            }

            .green {
                background-color: green;
            }

            .red {
                background-color: brown;
            }

            .yellow {
                background-color: yellow;
            }

            .hidden {
                display: none;
            }
        </style>
    </head>

    <body>
        <h1>Maze</h1>
        <h4>Click on green to start.</h4>

        <?php foreach ($maze as $x => $row) : ?>
        <div class="row">
            <?php foreach ($row as $y => $cell) : ?>
                <?php if (trim($cell)) : ?>
                    <?php
                    $color = 'green';
                    $buttonValue = ' ';
                    ?>
                    <?php foreach ($playerPath as $key => $value) : ?>
                        <?php if (isset($value[$x]) && $value[$x] === $y) {
                            $color = 'yellow';
                            $buttonValue = " $key ";
                        } ?>
                    <?php endforeach; ?>
                    <form action="/" method="post">
                        <input name="y" value="<?= $y ?>" class="hidden">
                        <input name="x" value="<?= $x ?>" class="hidden">
                        <input type="submit" value="<?= $buttonValue ?>" class="cell <?= $color ?>"/>
                    </form>
                <?php else : ?>
                    <div class="cell red"></div>
                <?php endif ?>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>

    </body>

</html>


