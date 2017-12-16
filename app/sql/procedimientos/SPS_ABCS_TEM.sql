-- Tipo de empresas
IF OBJECT_ID('SPS_ABCS_TEM','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_TEM
GO
CREATE PROCEDURE DBO.SPS_ABCS_TEM
(
	@ACCION                 VARCHAR(1) = 'S',
	@TipoEmpresaID           VARCHAR(2) = NULL,
    @DescripcionTipoEmpresa  VARCHAR(30) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[TEM]
           ([TipoEmpresaID]
           ,[DescripcionTipoEmpresa])
        SELECT @TipoEmpresaID, @DescripcionTipoEmpresa
        WHERE NOT EXISTS(SELECT * FROM [dbo].[TEM] WHERE TipoEmpresaID=@TipoEmpresaID )
        AND ISNULL(@TipoEmpresaID,'')<>'' AND ISNULL(@DescripcionTipoEmpresa,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[TEM] WHERE [dbo].[TEM].[TipoEmpresaID] = @TipoEmpresaID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[TEM]
        SET 
            [DescripcionTipoEmpresa] = CASE WHEN ISNULL(@DescripcionTipoEmpresa,'')='' THEN [DescripcionTipoEmpresa] ELSE @DescripcionTipoEmpresa END
        WHERE [TipoEmpresaID] = @TipoEmpresaID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [TipoEmpresaID]
            ,[DescripcionTipoEmpresa]
        FROM [dbo].[TEM]
        WHERE   1=1
        AND     [TipoEmpresaID] = CASE WHEN ISNULL(@TipoEmpresaID ,'')='' THEN [TipoEmpresaID] ELSE @TipoEmpresaID END
        AND     [DescripcionTipoEmpresa] = CASE WHEN ISNULL(@DescripcionTipoEmpresa ,'')='' THEN [DescripcionTipoEmpresa] ELSE @DescripcionTipoEmpresa END
        ORDER BY [DescripcionTipoEmpresa]
	END
END
GO
EXEC SPS_ABCS_TEM-- @TipoEmpresaID = '8'--, @CAMPO = 'TIPONOVEDAD'




