IF OBJECT_ID('SPS_ABCS_REPU','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_REPU
GO
CREATE PROCEDURE DBO.SPS_ABCS_REPU
(
	@ACCION			VARCHAR(1) = 'S',
	@REPORTEID		BIGINT = -1,
	@USUARIOID		VARCHAR(100) = '',
	@SEDEID			VARCHAR(100) = ''
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
		INSERT INTO REPU(REPORTEID,USUARIOID,SEDEID)
		SELECT @REPORTEID,@USUARIOID,@SEDEID
		WHERE NOT EXISTS(SELECT * FROM REPU WHERE REPORTEID=@REPORTEID AND USUARIOID=@USUARIOID AND SEDEID=@SEDEID)
	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM REPU WHERE REPORTEID=@REPORTEID AND USUARIOID=@USUARIOID AND SEDEID=@SEDEID
	END
	IF @ACCION = 'C'
	BEGIN
		UPDATE REPU SET 
			USUARIOID=@USUARIOID,
			SEDEID=@SEDEID
		WHERE REPORTEID=@REPORTEID
	END
	IF @ACCION = 'S'
	BEGIN
		SET @SQLString='SELECT REPU.REPORTEID, REPU.USUARIOID, USU.NOMBRE, REPU.SEDEID, SED.RAZONSOCIAL AS SEDE '
		SET @SQLString=@SQLString+'FROM REPU '
		SET @SQLString=@SQLString+'LEFT JOIN SED ON SED.SEDEID=REPU.SEDEID '
		SET @SQLString=@SQLString+'LEFT JOIN USU ON USU.SEDEID=REPU.SEDEID AND USU.USUARIOID=REPU.USUARIOID '
		SET @SQLString=@SQLString+'WHERE 1=1 '
		IF ISNULL(@SEDEID,'')<>'' SET @SQLString=@SQLString+'AND REPU.SEDEID = '''+@SEDEID+''' '
		IF ISNULL(@USUARIOID,'')<>'' SET @SQLString=@SQLString+'AND REPU.USUARIOID = '''+@USUARIOID+''' '
		IF ISNULL(@REPORTEID,-1)>0 SET @SQLString=@SQLString+'AND REPORTEID = ' + CAST(@REPORTEID AS VARCHAR)
		--PRINT @SQLSTRING
		EXECUTE sp_executesql @SQLString
	END
END
GO
EXEC DBO.SPS_ABCS_REPU @ACCION='A', @REPORTEID='1', @USUARIOID='EZERPA', @SEDEID='PPAL'
--EXEC DBO.SPS_ABCS_REPU @ACCION='B', @USUARIOID='EZERPA', @SEDEID='PPAL', @REPORTEID=1
EXEC DBO.SPS_ABCS_REPU @USUARIOID='EZERPA', @SEDEID='PPAL', @REPORTEID=1


--SELECT * FROM REPU WHERE 1=1 AND SEDEID = 'PPAL' AND USUARIOID = 'EZERPA' AND REPORTEID = 'CF45685A-6697-447A-B1EA-F10BA955B4079SAS' 
