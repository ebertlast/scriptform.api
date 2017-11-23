IF OBJECT_ID('SPS_ABCS_USU','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_USU
GO
CREATE PROCEDURE DBO.SPS_ABCS_USU
(
	@ACCION      VARCHAR(1) = 'S',
	@USUARIOID   VARCHAR(100) = '',
	@CLAVE	     VARCHAR(100) = '',
	@NOMBRE		 VARCHAR(100)='',
	@GRUPOID	 VARCHAR(100)='',
	@ACTIVO		 SMALLINT=0,
	@EMAIL		 VARCHAR(100)='',
	@USUARIOIDOLD VARCHAR(100)='',
	@SEDEID		  VARCHAR(100)=''
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
		INSERT INTO USU(USUARIOID,CLAVE,NOMBRE,GRUPOID,ACTIVO,EMAIL,SEDEID)
		SELECT @USUARIOID,ENCRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE('KEYCIFRAR'),LTRIM(RTRIM(@CLAVE))),@NOMBRE,@GRUPOID,@ACTIVO,@EMAIL,@SEDEID
		WHERE NOT EXISTS(SELECT * FROM USU WHERE USUARIOID=@USUARIOID)
	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM USU WHERE USUARIOID = @USUARIOID
	END
	IF @ACCION = 'C'
	BEGIN
		IF ISNULL(@USUARIOIDOLD,'')<>''
		BEGIN
			UPDATE USU SET 
				USUARIOID=@USUARIOID, 
				CLAVE=ENCRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE('KEYCIFRAR'),LTRIM(RTRIM(@CLAVE))),
				NOMBRE=@NOMBRE,
				GRUPOID=@GRUPOID,
				ACTIVO=@ACTIVO,
				EMAIL=@EMAIL,
				SEDEID=@SEDEID
			WHERE USUARIOID=@USUARIOIDOLD
		END
	END
	IF @ACCION = 'S'
	BEGIN

		SET @SQLString='SELECT USUARIOID,NOMBRE,USU.GRUPOID,GRU.DENOMINACION AS GRUPO,USU.ACTIVO,EMAIL '
		SET @SQLString=@SQLString+',EMP.RAZONSOCIAL AS EMPRESA, USU.SEDEID,SED.RAZONSOCIAL AS SEDE '
		SET @SQLString=@SQLString+'FROM USU '
		SET @SQLString=@SQLString+'LEFT JOIN GRU ON GRU.GRUPOID=USU.GRUPOID '
		SET @SQLString=@SQLString+'LEFT JOIN SED ON SED.SEDEID=USU.SEDEID '
		SET @SQLString=@SQLString+'LEFT JOIN EMP ON EMP.EMPRESAID=SED.EMPRESAID '
		SET @SQLString=@SQLString+'WHERE 1=1 '
		IF ISNULL(@USUARIOID,'')<>'' SET @SQLString=@SQLString+'AND USUARIOID = '''+@USUARIOID+''' '
		IF ISNULL(@CLAVE,'')<>'' SET @SQLString=@SQLString+'AND CONVERT(VARCHAR(300), DECRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE(''KEYCIFRAR''),CLAVE)) = '''+@CLAVE+''''
		IF ISNULL(@GRUPOID,'')<>'' SET @SQLString=@SQLString+'AND USU.GRUPOID = '''+@GRUPOID+''' '
		IF ISNULL(@EMAIL,'')<>'' SET @SQLString=@SQLString+'AND EMAIL = '''+@EMAIL+''' '
		IF ISNULL(@SEDEID,'')<>'' SET @SQLString=@SQLString+'AND USU.SEDEID = '''+@SEDEID+''' '

		--PRINT @SQLSTRING
		EXECUTE sp_executesql @SQLString
	 
	
			--AND	CLAVE = CASE WHEN ISNULL(@CLAVE,'')='' THEN CLAVE ELSE ENCRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE('KEYCIFRAR'),LTRIM(RTRIM(@CLAVE))) END
		END
END
GO
EXEC DBO.SPS_ABCS_USU @ACCION='A',@USUARIOID='EZERPA',@CLAVE='enclave', @NOMBRE='EBERT ZERPA',@GRUPOID='ADM',@ACTIVO=1,@EMAIL='ebert15@hotmail.com',@SEDEID='PPAL'
--EXEC DBO.SPS_ABCS_USU @ACCION='S',@USUARIOID='EZERPA',@CLAVE='enclave', @SEDEID='PPAL'
EXEC DBO.SPS_ABCS_USU



