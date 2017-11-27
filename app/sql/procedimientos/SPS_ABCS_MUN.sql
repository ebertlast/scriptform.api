IF OBJECT_ID('SPS_ABCS_MUN','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_MUN
GO
CREATE PROCEDURE DBO.SPS_ABCS_MUN
(
	@ACCION      		  VARCHAR(1) = 'S',
	@MunicipioID		  VARCHAR(10) = '',
	@DepartamentoID		  VARCHAR(2) = ''
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
		--PRINT 'AGREGAR'
        SET @ACCION='S'
	END 
	IF @ACCION = 'B'
	BEGIN
		-- PRINT 'BORRAR'
        SET @ACCION='S'
	END
	IF @ACCION = 'C'
	BEGIN
		-- PRINT 'CAMBIAR'
        SET @ACCION='S'
	END
	IF @ACCION = 'S'
	BEGIN

		SET @SQLString='SELECT MUN.*, DEP.DescripcionDepartamento '
		--SET @SQLString=@SQLString+',EMP.RAZONSOCIAL AS EMPRESA,SED.RAZONSOCIAL AS SEDE '
		SET @SQLString=@SQLString+'FROM MUN '
		SET @SQLString=@SQLString+'LEFT JOIN DEP ON DEP.DepartamentoID=MUN.DepartamentoID '
		--SET @SQLString=@SQLString+'LEFT JOIN SED ON SED.SEDEID=USU.SEDEID '
		--SET @SQLString=@SQLString+'LEFT JOIN EMP ON EMP.EMPRESAID=SED.EMPRESAID '
		SET @SQLString=@SQLString+'WHERE 1=1 '
		IF ISNULL(@MunicipioID,'')<>'' SET @SQLString=@SQLString+'AND MunicipioID = '''+@MunicipioID+''' '
		IF ISNULL(@DepartamentoID,'')<>'' SET @SQLString=@SQLString+'AND MUN.DepartamentoID = '''+@DepartamentoID+''' '
		--IF ISNULL(@EMAIL,'')<>'' SET @SQLString=@SQLString+'AND EMAIL = '''+@EMAIL+''' '
		--IF ISNULL(@SEDEID,'')<>'' SET @SQLString=@SQLString+'AND USU.SEDEID = '''+@SEDEID+''' '

		--PRINT @SQLSTRING
		EXECUTE sp_executesql @SQLString
		-- SELECT * FROM AFI
	 
	
			--AND	CLAVE = CASE WHEN ISNULL(@CLAVE,'')='' THEN CLAVE ELSE ENCRYPTBYPASSPHRASE(DBO.FNS_VALORVARIABLE('KEYCIFRAR'),LTRIM(RTRIM(@CLAVE))) END
		END
END
GO
EXEC DBO.SPS_ABCS_MUN 




