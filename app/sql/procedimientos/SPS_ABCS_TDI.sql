IF OBJECT_ID('SPS_ABCS_TDI','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_TDI
GO
CREATE PROCEDURE DBO.SPS_ABCS_TDI
(
	@ACCION             VARCHAR(1) = 'S',
	@TipoDiscapacidadId           VARCHAR(2) = NULL,
    @DescripcionTipoDiscapacidad  VARCHAR(15) = NULL,
    @LargoTipoDiscapacidad        INT = NULL,
    @TipoDatoTipoDiscapacidad     VARCHAR(10) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[TDI]
           ([TipoDiscapacidadId]
           ,[DescripcionTipoDiscapacidad]
           ,[LargoTipoDiscapacidad]
           ,[TipoDatoTipoDiscapacidad])
        SELECT @TipoDiscapacidadId, @DescripcionTipoDiscapacidad, @LargoTipoDiscapacidad, @TipoDatoTipoDiscapacidad
        WHERE NOT EXISTS(SELECT * FROM [dbo].[TDI] WHERE TipoDiscapacidadId=@TipoDiscapacidadId )
        AND ISNULL(@TipoDiscapacidadId,'')<>'' AND ISNULL(@DescripcionTipoDiscapacidad,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[TDI] WHERE [dbo].[TDI].[TipoDiscapacidadId] = @TipoDiscapacidadId
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[TDI]
        SET 
            [DescripcionTipoDiscapacidad] = CASE WHEN ISNULL(@DescripcionTipoDiscapacidad,'')='' THEN [DescripcionTipoDiscapacidad] ELSE @DescripcionTipoDiscapacidad END
            ,[LargoTipoDiscapacidad] = CASE WHEN ISNULL(@LargoTipoDiscapacidad,-1)<0 THEN [LargoTipoDiscapacidad] ELSE @LargoTipoDiscapacidad END
            ,[TipoDatoTipoDiscapacidad] = CASE WHEN ISNULL(@TipoDatoTipoDiscapacidad,'')='' THEN [TipoDatoTipoDiscapacidad] ELSE @TipoDatoTipoDiscapacidad END
        WHERE [TipoDiscapacidadId] = @TipoDiscapacidadId 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [TipoDiscapacidadId]
            ,[DescripcionTipoDiscapacidad]
            ,[LargoTipoDiscapacidad]
            ,[TipoDatoTipoDiscapacidad]
        FROM [dbo].[TDI]
        WHERE   1=1
        AND     [TipoDiscapacidadId] = CASE WHEN ISNULL(@TipoDiscapacidadId ,'')='' THEN [TipoDiscapacidadId] ELSE @TipoDiscapacidadId END
        AND     [DescripcionTipoDiscapacidad] = CASE WHEN ISNULL(@DescripcionTipoDiscapacidad ,'')='' THEN [DescripcionTipoDiscapacidad] ELSE @DescripcionTipoDiscapacidad END
        AND     [TipoDatoTipoDiscapacidad] = CASE WHEN ISNULL(@TipoDatoTipoDiscapacidad,'')='' THEN [TipoDatoTipoDiscapacidad] ELSE @TipoDatoTipoDiscapacidad END
        AND     [LargoTipoDiscapacidad] = CASE WHEN ISNULL(@LargoTipoDiscapacidad,-1)<0 THEN [LargoTipoDiscapacidad] ELSE @LargoTipoDiscapacidad END
        ORDER BY [DescripcionTipoDiscapacidad]
	END
END
GO
EXEC SPS_ABCS_TDI 




