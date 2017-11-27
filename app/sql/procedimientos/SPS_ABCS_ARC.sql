IF OBJECT_ID('SPS_ABCS_ARC','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_ARC
GO
CREATE PROCEDURE DBO.SPS_ABCS_ARC
(
	@ACCION			        VARCHAR(1) = 'S',
    @ARCHIVOID              VARCHAR(20) = '',
	@FORMULARIOID           VARCHAR(20) = '',
	@TIPOID                 VARCHAR(2) = '',
	@NUMEROIDENTIFICACION   VARCHAR(16) = '',
    @FECHARADICACION        DATETIME = NULL,
    @MUNICIPIOID            VARCHAR(10) = '',
    @USUARIOID              VARCHAR(100) = '',
    @SEDEID                 VARCHAR(100) = '',
    @NUEVOREGISTRO          SMALLINT = -1,
    @CANTIDADBENEFICIARIOS  SMALLINT = -1,
    @FDESDE                 DATETIME = NULL,
    @FHASTA                 DATETIME = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
    
	    INSERT INTO dbo.ARC(
            ARCHIVOID
            ,FORMULARIOID
            ,TIPOID
            ,NUMEROIDENTIFICACION
        --    ,FECHAREGISTRO
        --    ,FECHARADICACION
            ,MUNICIPIOID
            ,USUARIOID
            ,SEDEID
            ,NUEVOREGISTRO
            ,CANTIDADBENEFICIARIOS
        )
		SELECT CASE WHEN ISNULL(@ARCHIVOID,'')='' THEN REPLACE(RIGHT(NEWID(),20),'-','') ELSE @ARCHIVOID END
            ,@FORMULARIOID
            ,@TIPOID
            ,@NUMEROIDENTIFICACION
            ,@MUNICIPIOID
            ,@USUARIOID
            ,@SEDEID
            ,@NUEVOREGISTRO
            ,@CANTIDADBENEFICIARIOS
		WHERE NOT EXISTS(SELECT * FROM ARC WHERE ARCHIVOID=@ARCHIVOID)
	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM ARC WHERE ARCHIVOID = @ARCHIVOID
		-- AND ARCHIVOID NOT IN (SELECT DISTINCT ARCHIVOID FROM ARCH)
	END
	IF @ACCION = 'C'
	BEGIN
        SET @SQLString='UPDATE ARC SET ARCHIVOID=ARCHIVOID '

        IF ISNULL(@FORMULARIOID,'')<>'' SET @SQLString=@SQLString+', FORMULARIOID = '''+@FORMULARIOID+''' '
        IF ISNULL(@TIPOID,'')<>'' SET @SQLString=@SQLString+', TIPOID = '''+@TIPOID+''' '
        IF ISNULL(@NUMEROIDENTIFICACION,'')<>'' SET @SQLString=@SQLString+', NUMEROIDENTIFICACION = '''+@NUMEROIDENTIFICACION+''' '
        IF @FECHARADICACION IS NOT NULL SET @SQLString=@SQLString+', FECHARADICACION = '''+dbo.FNS_FECHA_CADENA(@FECHARADICACION)+''' '
        IF ISNULL(@MUNICIPIOID,'')<>'' SET @SQLString=@SQLString+', MUNICIPIOID = '''+@MUNICIPIOID+''' '
        IF ISNULL(@USUARIOID,'')<>'' SET @SQLString=@SQLString+', USUARIOID = '''+@USUARIOID+''' '
        IF ISNULL(@SEDEID,'')<>'' SET @SQLString=@SQLString+', SEDEID = '''+@SEDEID+''' '
        IF ISNULL(@NUEVOREGISTRO,-1)>=0 SET @SQLString=@SQLString+', NUEVOREGISTRO = '+CAST(@NUEVOREGISTRO AS VARCHAR)
        IF ISNULL(@CANTIDADBENEFICIARIOS,-1)>=0 SET @SQLString=@SQLString+', CANTIDADBENEFICIARIOS = '+CAST(@CANTIDADBENEFICIARIOS AS VARCHAR)

		SET @SQLString=@SQLString+'WHERE ARCHIVOID=''' + @ARCHIVOID + ''' '
		EXECUTE sp_executesql @SQLString
        
	END
	IF @ACCION = 'S'
	BEGIN

        IF @FDESDE IS NOT NULL SET @FDESDE=dbo.FNS_FECHA_SIN_HORA(@FDESDE)
        IF @FHASTA IS NULL SET @FHASTA=@FDESDE
        IF @FHASTA IS NOT NULL SET @FHASTA=dbo.FNS_FECHA_SIN_HORA(@FHASTA)

		SET @SQLString='SELECT ARC.*, TID.DescripcionID AS TIPODOCUMENTO '
		SET @SQLString=@SQLString+', MUN.DescripcionMunicipio MUNICIPIO '
		SET @SQLString=@SQLString+', USU.NOMBRE USUARIO '
		SET @SQLString=@SQLString+'FROM ARC LEFT JOIN TID ON TID.TipoID=ARC.TIPOID '
		SET @SQLString=@SQLString+'LEFT JOIN MUN ON MUN.MunicipioID=ARC.MUNICIPIOID '
		SET @SQLString=@SQLString+'LEFT JOIN USU ON USU.USUARIOID=ARC.USUARIOID '
		SET @SQLString=@SQLString+'WHERE 1=1 '

        IF ISNULL(@FORMULARIOID,'')<>'' SET @SQLString=@SQLString+'AND FORMULARIOID = '''+@FORMULARIOID+''' '
        IF ISNULL(@TIPOID,'')<>'' SET @SQLString=@SQLString+'AND TIPOID = '''+@TIPOID+''' '
        IF ISNULL(@NUMEROIDENTIFICACION,'')<>'' SET @SQLString=@SQLString+'AND NUMEROIDENTIFICACION = '''+@NUMEROIDENTIFICACION+''' '
        IF @FECHARADICACION IS NOT NULL SET @SQLString=@SQLString+'AND FECHARADICACION = '''+dbo.FNS_FECHA_CADENA(@FECHARADICACION)+''' '
        IF ISNULL(@MUNICIPIOID,'')<>'' SET @SQLString=@SQLString+'AND MUNICIPIOID = '''+@MUNICIPIOID+''' '
        IF ISNULL(@USUARIOID,'')<>'' SET @SQLString=@SQLString+'AND USUARIOID = '''+@USUARIOID+''' '
        IF ISNULL(@SEDEID,'')<>'' SET @SQLString=@SQLString+'AND SEDEID = '''+@SEDEID+''' '
        IF ISNULL(@NUEVOREGISTRO,-1)>=0 SET @SQLString=@SQLString+'AND NUEVOREGISTRO = '+CAST(@NUEVOREGISTRO AS VARCHAR)
        IF ISNULL(@CANTIDADBENEFICIARIOS,-1)>=0 SET @SQLString=@SQLString+'AND CANTIDADBENEFICIARIOS = '+CAST(@CANTIDADBENEFICIARIOS AS VARCHAR)
        IF @FDESDE IS NOT NULL SET @SQLString=@SQLString+'AND FECHARADICACION >= '''+dbo.FNS_FECHA_CADENA(@FDESDE)+''' '
        IF @FHASTA IS NOT NULL SET @SQLString=@SQLString+'AND FECHARADICACION <= '''+dbo.FNS_FECHA_CADENA(@FHASTA)+''' '
        
        SET @SQLString=@SQLString+'ORDER BY FECHAREGISTRO'

		--PRINT @SQLSTRING
		EXECUTE sp_executesql @SQLString
	 
	
		END
END
GO
EXEC DBO.SPS_ABCS_ARC 




