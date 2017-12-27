IF OBJECT_ID('SPS_ABCS_ECI','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_ECI
GO
CREATE PROCEDURE DBO.SPS_ABCS_ECI
(
	@ACCION             VARCHAR(1) = 'S',
	@EstadoId           VARCHAR(2) = NULL,
    @DescripcionEstado  VARCHAR(15) = NULL,
    @LargoEstado        INT = NULL,
    @TipoDato           VARCHAR(10) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[ECI]
           ([EstadoId]
           ,[DescripcionEstado]
           ,[LargoEstado]
           ,[TipoDato])
        SELECT @EstadoId, @DescripcionEstado, @LargoEstado, @TipoDato
        WHERE NOT EXISTS(SELECT * FROM [dbo].[ECI] WHERE EstadoId=@EstadoId )
        AND ISNULL(@EstadoId,'')<>'' AND ISNULL(@DescripcionEstado,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[ECI] WHERE [dbo].[ECI].[EstadoId] = @EstadoId
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[ECI]
        SET 
            [DescripcionEstado] = CASE WHEN ISNULL(@DescripcionEstado,'')='' THEN [DescripcionEstado] ELSE @DescripcionEstado END
            ,[LargoEstado] = CASE WHEN ISNULL(@LargoEstado,-1)<0 THEN [LargoEstado] ELSE @LargoEstado END
            ,[TipoDato] = CASE WHEN ISNULL(@TipoDato,'')='' THEN [TipoDato] ELSE @TipoDato END
        WHERE [EstadoId] = @EstadoId 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [EstadoId]
            ,[DescripcionEstado]
            ,[LargoEstado]
            ,[TipoDato]
        FROM [dbo].[ECI]
        WHERE   1=1
        AND     [EstadoId] = CASE WHEN ISNULL(@EstadoId ,'')='' THEN [EstadoId] ELSE @EstadoId END
        AND     [DescripcionEstado] = CASE WHEN ISNULL(@DescripcionEstado ,'')='' THEN [DescripcionEstado] ELSE @DescripcionEstado END
        AND     [TipoDato] = CASE WHEN ISNULL(@TipoDato,'')='' THEN [TipoDato] ELSE @TipoDato END
        AND     [LargoEstado] = CASE WHEN ISNULL(@LargoEstado,-1)<0 THEN [LargoEstado] ELSE @LargoEstado END
        ORDER BY [DescripcionEstado]
	END
END
GO
EXEC SPS_ABCS_ECI 




