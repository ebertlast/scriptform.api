IF OBJECT_ID('SPS_ABCS_TIPR','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_TIPR
GO
CREATE PROCEDURE DBO.SPS_ABCS_TIPR
(
	@ACCION                     VARCHAR(1) = 'S',
	@TipoRelacionID             INT = NULL,
    @DescripcionTipoRelacion    VARCHAR(15) = NULL,
    @LargoTipoRelacion          INT = NULL,
    @TipoDatoTipoRelacion       VARCHAR(10) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[TIPR]
           ([TipoRelacionID]
           ,[DescripcionTipoRelacion]
           ,[LargoTipoRelacion]
           ,[TipoDatoTipoRelacion])
        SELECT @TipoRelacionID, @DescripcionTipoRelacion, @LargoTipoRelacion, @TipoDatoTipoRelacion
        WHERE NOT EXISTS(SELECT * FROM [dbo].[TIPR] WHERE TipoRelacionID=@TipoRelacionID )
        AND ISNULL(@TipoRelacionID,'')<>'' AND ISNULL(@DescripcionTipoRelacion,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[TIPR] WHERE [dbo].[TIPR].[TipoRelacionID] = @TipoRelacionID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[TIPR]
        SET 
            [DescripcionTipoRelacion] = CASE WHEN ISNULL(@DescripcionTipoRelacion,'')='' THEN [DescripcionTipoRelacion] ELSE @DescripcionTipoRelacion END
            ,[LargoTipoRelacion] = CASE WHEN ISNULL(@LargoTipoRelacion,-1)<0 THEN [LargoTipoRelacion] ELSE @LargoTipoRelacion END
            ,[TipoDatoTipoRelacion] = CASE WHEN ISNULL(@TipoDatoTipoRelacion,'')='' THEN [TipoDatoTipoRelacion] ELSE @TipoDatoTipoRelacion END
        WHERE [TipoRelacionID] = @TipoRelacionID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [TipoRelacionID]
            ,[DescripcionTipoRelacion]
            ,[LargoTipoRelacion]
            ,[TipoDatoTipoRelacion]
        FROM [dbo].[TIPR]
        WHERE   1=1
        AND     [TipoRelacionID] = CASE WHEN ISNULL(@TipoRelacionID ,-1)<0 THEN [TipoRelacionID] ELSE @TipoRelacionID END
        AND     [DescripcionTipoRelacion] = CASE WHEN ISNULL(@DescripcionTipoRelacion ,'')='' THEN [DescripcionTipoRelacion] ELSE @DescripcionTipoRelacion END
        AND     [TipoDatoTipoRelacion] = CASE WHEN ISNULL(@TipoDatoTipoRelacion,'')='' THEN [TipoDatoTipoRelacion] ELSE @TipoDatoTipoRelacion END
        AND     [LargoTipoRelacion] = CASE WHEN ISNULL(@LargoTipoRelacion,-1)<0 THEN [LargoTipoRelacion] ELSE @LargoTipoRelacion END
        ORDER BY [DescripcionTipoRelacion]
	END
END
GO
EXEC SPS_ABCS_TIPR 




