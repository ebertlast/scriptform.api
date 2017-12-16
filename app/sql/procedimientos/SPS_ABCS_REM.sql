-- Regimen de empresas
IF OBJECT_ID('SPS_ABCS_REM','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_REM
GO
CREATE PROCEDURE DBO.SPS_ABCS_REM
(
	@ACCION                     VARCHAR(1) = 'S',
	@RegimeEmpresaID            VARCHAR(2) = NULL,
    @DescripcionRegimenEmpresa  VARCHAR(15) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[REM]
           ([RegimeEmpresaID]
           ,[DescripcionRegimenEmpresa])
        SELECT @RegimeEmpresaID, @DescripcionRegimenEmpresa
        WHERE NOT EXISTS(SELECT * FROM [dbo].[REM] WHERE RegimeEmpresaID=@RegimeEmpresaID )
        AND ISNULL(@RegimeEmpresaID,'')<>'' AND ISNULL(@DescripcionRegimenEmpresa,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[REM] WHERE [dbo].[REM].[RegimeEmpresaID] = @RegimeEmpresaID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[REM]
        SET 
            [DescripcionRegimenEmpresa] = CASE WHEN ISNULL(@DescripcionRegimenEmpresa,'')='' THEN [DescripcionRegimenEmpresa] ELSE @DescripcionRegimenEmpresa END
        WHERE [RegimeEmpresaID] = @RegimeEmpresaID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [RegimeEmpresaID]
            ,[DescripcionRegimenEmpresa]
        FROM [dbo].[REM]
        WHERE   1=1
        AND     [RegimeEmpresaID] = CASE WHEN ISNULL(@RegimeEmpresaID ,'')='' THEN [RegimeEmpresaID] ELSE @RegimeEmpresaID END
        AND     [DescripcionRegimenEmpresa] = CASE WHEN ISNULL(@DescripcionRegimenEmpresa ,'')='' THEN [DescripcionRegimenEmpresa] ELSE @DescripcionRegimenEmpresa END
        ORDER BY [DescripcionRegimenEmpresa]
	END
END
GO
EXEC SPS_ABCS_REM --@TABLA = 'GENERAL', @CAMPO = 'TIPONOVEDAD'




