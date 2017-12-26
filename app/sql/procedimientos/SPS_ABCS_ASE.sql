-- Tipo de empresas
IF OBJECT_ID('SPS_ABCS_ASE','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_ASE
GO
CREATE PROCEDURE DBO.SPS_ABCS_ASE
(
	@ACCION                 VARCHAR(1) = 'S',
	@AsesorID               VARCHAR(15) = NULL,
    @NombreAsesor           VARCHAR(1000) = NULL,
    @AsesorIDAlterno        VARCHAR(15) = NULL,
	@NombreAsesorAlterno    VARCHAR(1000) = NULL,
	@AsesorEstado           BIT = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[ASE]
           ([AsesorID]
           ,[NombreAsesor],[AsesorIDAlterno],[NombreAsesorAlterno],[AsesorEstado])
        SELECT @AsesorID, @NombreAsesor, @AsesorIDAlterno, @NombreAsesorAlterno, @AsesorEstado
        WHERE NOT EXISTS(SELECT * FROM [dbo].[ASE] WHERE AsesorID=@AsesorID )
        AND ISNULL(@AsesorID,'')<>'' AND ISNULL(@NombreAsesor,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[ASE] WHERE [dbo].[ASE].[AsesorID] = @AsesorID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[ASE]
        SET 
            [NombreAsesor] = CASE WHEN ISNULL(@NombreAsesor,'')='' THEN [NombreAsesor] ELSE @NombreAsesor END,
            [AsesorIDAlterno] = CASE WHEN ISNULL(@AsesorIDAlterno,'')='' THEN [AsesorIDAlterno] ELSE @AsesorIDAlterno END,
            [NombreAsesorAlterno] = CASE WHEN ISNULL(@NombreAsesorAlterno,'')='' THEN [NombreAsesorAlterno] ELSE @NombreAsesorAlterno END,
            [AsesorEstado] = CASE WHEN ISNULL(@AsesorEstado,'')='' THEN [AsesorEstado] ELSE @AsesorEstado END
        WHERE [AsesorID] = @AsesorID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [AsesorID]
            ,[NombreAsesor]
            ,[AsesorIDAlterno]
            ,[NombreAsesorAlterno]
            ,[AsesorEstado]
        FROM [dbo].[ASE]
        WHERE   1=1
        AND     [AsesorID] = CASE WHEN ISNULL(@AsesorID ,'')='' THEN [AsesorID] ELSE @AsesorID END
        AND     [NombreAsesor] = CASE WHEN ISNULL(@NombreAsesor ,'')='' THEN [NombreAsesor] ELSE @NombreAsesor END
        AND     [NombreAsesorAlterno] = CASE WHEN ISNULL(@NombreAsesorAlterno ,'')='' THEN [NombreAsesorAlterno] ELSE @NombreAsesorAlterno END
        AND     [AsesorEstado] = CASE WHEN @AsesorEstado IS NULL THEN [AsesorEstado] ELSE @AsesorEstado END
        ORDER BY [NombreAsesor]
	END
END
GO
EXEC SPS_ABCS_ASE-- @AsesorID = '8'--, @CAMPO = 'TIPONOVEDAD'




