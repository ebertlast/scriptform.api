IF OBJECT_ID('SPS_ABCS_REP','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_REP
GO
CREATE PROCEDURE DBO.SPS_ABCS_REP
(
	@ACCION			VARCHAR(1) = 'S',
	@REPORTEID		VARCHAR(100) = '',
	@NOMBRE			VARCHAR(500) = '',
	@QUERY			VARCHAR(MAX) = '',
	@USUARIOID		VARCHAR(100) = '',
	@SEDEID			VARCHAR(100) = ''
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
		INSERT INTO REP(NOMBRE,QUERY)
		SELECT @NOMBRE,@QUERY
		--WHERE NOT EXISTS(SELECT * FROM SED WHERE SEDEID=@SEDEID)
	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM REP WHERE REPORTEID = @REPORTEID
		AND REPORTEID NOT IN (SELECT DISTINCT REPORTEID FROM REPU)
	END
	IF @ACCION = 'C'
	BEGIN
		UPDATE REP SET 
			NOMBRE=CASE WHEN ISNULL(@NOMBRE,'')<>'' THEN @NOMBRE ELSE NOMBRE END,
			QUERY=CASE WHEN ISNULL(@QUERY,'')<>'' THEN @QUERY ELSE QUERY END
		WHERE REPORTEID=@REPORTEID
	END
	IF @ACCION = 'S'
	BEGIN
		SET @SQLString='SELECT * '
		SET @SQLString=@SQLString+'FROM REP '
		IF ISNULL(@REPORTEID,'')<>'' SET @SQLString=@SQLString+'WHERE REPORTEID = '''+ @REPORTEID +''' '
		IF ISNULL(@SEDEID,'')<>'' AND ISNULL(@USUARIOID,'')<>''
		BEGIN
			SET @SQLString=@SQLString+'WHERE REPORTEID IN (SELECT REPORTEID FROM REPU WHERE SEDEID=''' + @SEDEID + ''' AND USUARIOID=''' + @USUARIOID + ''') '
		END
		--ELSE
		--BEGIN
		--	SET @SQLString=@SQLString+'WHERE 1=2 '
		--END
		--PRINT @SQLSTRING
		EXECUTE sp_executesql @SQLString
	END
END
GO
--EXEC DBO.SPS_ABCS_REP @ACCION='A',@NOMBRE='AFILIADOS',@QUERY='EXEC DBO.SPS_ABCS_AFI'
--EXEC DBO.SPS_ABCS_REP @USUARIOID='EZERPA', @SEDEID='PPAL'--@SEDEID='ppal'
EXEC DBO.SPS_ABCS_REP @USUARIOID='EZERPA', @SEDEID='PPAL'--, @REPORTEID='1'

--EXEC DBO.SPS_ABCS_REP @ACCION='C',@REPORTEID='1',@QUERY='SELECT top 1000 * FROM [ScriptForms].[dbo].[AFI]'

--select * from rep