IF OBJECT_ID('SPS_ABCS_AFI','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_AFI
GO
CREATE PROCEDURE DBO.SPS_ABCS_AFI
(
	@ACCION      VARCHAR(1) = 'S'
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
		--INSERT INTO USU(USUARIOID,CLAVE,NOMBRE,GRUPOID,ACTIVO,EMAIL,SEDEID)
		--SELECT @USUARIOID,ENCRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE('KEYCIFRAR'),LTRIM(RTRIM(@CLAVE))),@NOMBRE,@GRUPOID,@ACTIVO,@EMAIL,@SEDEID
		--WHERE NOT EXISTS(SELECT * FROM USU WHERE USUARIOID=@USUARIOID)
		PRINT 'AGREGAR'
	END 
	IF @ACCION = 'B'
	BEGIN
		--DELETE FROM USU WHERE USUARIOID = @USUARIOID
		PRINT 'BORRAR'
	END
	IF @ACCION = 'C'
	BEGIN
		--IF ISNULL(@USUARIOIDOLD,'')<>''
		--BEGIN
		--	UPDATE USU SET 
		--		USUARIOID=@USUARIOID, 
		--		CLAVE=ENCRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE('KEYCIFRAR'),LTRIM(RTRIM(@CLAVE))),
		--		NOMBRE=@NOMBRE,
		--		GRUPOID=@GRUPOID,
		--		ACTIVO=@ACTIVO,
		--		EMAIL=@EMAIL,
		--		SEDEID=@SEDEID
		--	WHERE USUARIOID=@USUARIOIDOLD
		--END
		PRINT 'CAMBIAR'
	END
	IF @ACCION = 'S'
	BEGIN

		SET @SQLString='SELECT top 20000 * '
		--SET @SQLString=@SQLString+',EMP.RAZONSOCIAL AS EMPRESA,SED.RAZONSOCIAL AS SEDE '
		SET @SQLString=@SQLString+'FROM AFI '
		--SET @SQLString=@SQLString+'LEFT JOIN GRU ON GRU.GRUPOID=USU.GRUPOID '
		--SET @SQLString=@SQLString+'LEFT JOIN SED ON SED.SEDEID=USU.SEDEID '
		--SET @SQLString=@SQLString+'LEFT JOIN EMP ON EMP.EMPRESAID=SED.EMPRESAID '
		SET @SQLString=@SQLString+'WHERE 1=1 '
		--IF ISNULL(@USUARIOID,'')<>'' SET @SQLString=@SQLString+'AND USUARIOID = '''+@USUARIOID+''' '
		--IF ISNULL(@CLAVE,'')<>'' SET @SQLString=@SQLString+'AND CONVERT(VARCHAR(300), DECRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE(''KEYCIFRAR''),CLAVE)) = '''+@CLAVE+''''
		--IF ISNULL(@GRUPOID,'')<>'' SET @SQLString=@SQLString+'AND USU.GRUPOID = '''+@GRUPOID+''' '
		--IF ISNULL(@EMAIL,'')<>'' SET @SQLString=@SQLString+'AND EMAIL = '''+@EMAIL+''' '
		--IF ISNULL(@SEDEID,'')<>'' SET @SQLString=@SQLString+'AND USU.SEDEID = '''+@SEDEID+''' '

		--PRINT @SQLSTRING
		--EXECUTE sp_executesql @SQLString
		SELECT * FROM AFI
	 
	
			--AND	CLAVE = CASE WHEN ISNULL(@CLAVE,'')='' THEN CLAVE ELSE ENCRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE('KEYCIFRAR'),LTRIM(RTRIM(@CLAVE))) END
		END
END
GO
EXEC DBO.SPS_ABCS_AFI



