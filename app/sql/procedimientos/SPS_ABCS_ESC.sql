IF OBJECT_ID('SPS_ABCS_ESC','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_ESC
GO
CREATE PROCEDURE DBO.SPS_ABCS_ESC
(
	@ACCION                      VARCHAR(1) = 'S',
	@TipoEscolaridadId           VARCHAR(20) = NULL,
    @DescripcionTipoEscolaridad  VARCHAR(20) = NULL,
    @LargoTipoEscolaridad        INT = NULL,
    @TipoDatoTipoEscolaridad     VARCHAR(10) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[ESC]
           ([TipoEscolaridadId]
           ,[DescripcionTipoEscolaridad]
           ,[LargoTipoEscolaridad]
           ,[TipoDatoTipoEscolaridad])
        SELECT @TipoEscolaridadId, @DescripcionTipoEscolaridad, @LargoTipoEscolaridad, @TipoDatoTipoEscolaridad
        WHERE NOT EXISTS(SELECT * FROM [dbo].[ESC] WHERE TipoEscolaridadId=@TipoEscolaridadId )
        AND ISNULL(@TipoEscolaridadId,'')<>'' AND ISNULL(@DescripcionTipoEscolaridad,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[ESC] WHERE [dbo].[ESC].[TipoEscolaridadId] = @TipoEscolaridadId
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[ESC]
        SET 
            [DescripcionTipoEscolaridad] = CASE WHEN ISNULL(@DescripcionTipoEscolaridad,'')='' THEN [DescripcionTipoEscolaridad] ELSE @DescripcionTipoEscolaridad END
            ,[LargoTipoEscolaridad] = CASE WHEN ISNULL(@LargoTipoEscolaridad,-1)<0 THEN [LargoTipoEscolaridad] ELSE @LargoTipoEscolaridad END
            ,[TipoDatoTipoEscolaridad] = CASE WHEN ISNULL(@TipoDatoTipoEscolaridad,'')='' THEN [TipoDatoTipoEscolaridad] ELSE @TipoDatoTipoEscolaridad END
        WHERE [TipoEscolaridadId] = @TipoEscolaridadId 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [TipoEscolaridadId]
            ,[DescripcionTipoEscolaridad]
            ,[LargoTipoEscolaridad]
            ,[TipoDatoTipoEscolaridad]
        FROM [dbo].[ESC]
        WHERE   1=1
        AND     [TipoEscolaridadId] = CASE WHEN ISNULL(@TipoEscolaridadId ,'')='' THEN [TipoEscolaridadId] ELSE @TipoEscolaridadId END
        AND     [DescripcionTipoEscolaridad] = CASE WHEN ISNULL(@DescripcionTipoEscolaridad ,'')='' THEN [DescripcionTipoEscolaridad] ELSE @DescripcionTipoEscolaridad END
        AND     [TipoDatoTipoEscolaridad] = CASE WHEN ISNULL(@TipoDatoTipoEscolaridad,'')='' THEN [TipoDatoTipoEscolaridad] ELSE @TipoDatoTipoEscolaridad END
        AND     [LargoTipoEscolaridad] = CASE WHEN ISNULL(@LargoTipoEscolaridad,-1)<0 THEN [LargoTipoEscolaridad] ELSE @LargoTipoEscolaridad END
        ORDER BY [DescripcionTipoEscolaridad]
	END
END
GO
EXEC SPS_ABCS_ESC 




