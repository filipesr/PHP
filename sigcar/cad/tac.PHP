<?php $modulotab = "tac"; ?>
<?php require("../loga.php"); ?>
<html>
    <body>

        <table id="Detail_999999" style="display:block">
            <tr>
            <form action="" method="POST" name="filtro">
                <?php $w .= retRequest('acdesc', "AND acdesc LIKE '%", "%'"); ?>
                <td>&nbsp;Descri&ccedil;&atilde;o</td><td><input class="form03" name="acdesc" value="<?php echo retRequest('acdesc'); ?>" type="Text"></td>
                <?php $w .= retRequest('acabrev', "AND acabrev LIKE '%", "%'"); ?>
                <td>&nbsp;Abrevia&ccedil;o</td><td><input class="form03" name="acabrev" value="<?php echo retRequest('acabrev'); ?>" type="Text"></td>
                <td>
                    <input class="btPesq" name="bpesq" type="submit" id="bpesq" value="Pesquisar">
                    <input class="btPesq" name="Limpar" value="Limpar" type="reset">
                    <img align="absbottom" alt="Ocultar campos de pesquisa" onClick="javascript:detailbox('999999');" src="../imagens/ocultpesq.gif">
                </td>
            </form>
        </tr>
    </table>

    <table>
        <tr style="<?php echo $TitItem ?>">
            <td><?php aTit("acdesc", "Descri&ccedil;&atilde;o") ?></td>
            <td><?php aTit("acabrev", "Abrevia&ccedil;&atilde;o") ?></td>
            <td nowrap>&nbsp;</td>
            <?php
            $colspan = 6;
            //Executa a consulta
            $sql = "Select * from tac WHERE 1=1 " . $w;
            $res = sqlexec($id, $sql . retRequest('ordem') . " " . retRequest('desc'));
            //Exibe as linhas encontradas na consulta
            $l = 0;
            while ($row = mysql_fetch_array($res)) {
                $style = $l % 2 == 0 ? $ItemPar : $ItemImpar;
                $l++;
                ?>
            <tr style="<?php echo $style; ?>" nowrap="nowrap">
            <form action="<?php echo $home; ?>/cad/cadtac.php" method="POST" name="tac">
                <input name="oper" type="hidden" value="Editar">
                <input class="form03" name="idac" type="hidden" value="<?php echo $row['idac']; ?>">
                <input class="form03" name="acdesc" type="hidden" value="<?php echo $row['acdesc']; ?>">
                <td>&nbsp;<?php echo $row['acdesc']; ?></td>
                <input class="form03" name="acabrev" type="hidden" value="<?php echo $row['acabrev']; ?>">
                <td>&nbsp;<?php echo $row['acabrev']; ?></td>
                <td>&nbsp;<input class="btEdt" type="submit" value="Editar"></td>
            </form>

            <form name="Exc<?php echo $row['idac']; ?>" action="<?php echo $home; ?>/cad/envia_cadtac.php" method="POST">
                <input name="idac" type="hidden" value="<?php echo $row['idac']; ?>">
                <input name="oper" type="hidden" value="Apagar">
                <td><input name="Excluir" class="btExc" type="button" onClick="javascript:if (confirm( & quot; Tem certeza? & quot; )){
                                    document.Exc<?php echo $row['idac']; ?>.submit();
                                }" value="Excluir"></td>
            </form>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="<?php echo $colspan; ?>">&nbsp;
            <div align="center">
                <form action="<?php echo $home; ?>/cad/cadtac.php" method="POST">
                    <input name="oper" type="hidden" value="Inserir">
                    <input class="btIns" type="submit" value="Inserir">
                </form>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
