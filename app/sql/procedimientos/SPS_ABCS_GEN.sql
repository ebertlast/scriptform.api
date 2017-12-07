IF OBJECT_ID('SPS_ABCS_GEN','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_GEN
GO
CREATE PROCEDURE DBO.SPS_ABCS_GEN
(
	@ACCION             VARCHAR(1) = 'S',
	@GeneroID           VARCHAR(2) = NULL,
    @DescripcionGenero  VARCHAR(15) = NULL,
    @LargoGenero        INT = NULL,
    @TipoDatoGenero     VARCHAR(10) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[GEN]
           ([GeneroID]
           ,[DescripcionGenero]
           ,[LargoGenero]
           ,[TipoDatoGenero])
        SELECT @GeneroID, @DescripcionGenero, @LargoGenero, @TipoDatoGenero
        WHERE NOT EXISTS(SELECT * FROM [dbo].[GEN] WHERE GeneroID=@GeneroID )
        AND ISNULL(@GeneroID,'')<>'' AND ISNULL(@DescripcionGenero,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[GEN] WHERE [dbo].[GEN].[GeneroID] = @GeneroID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[GEN]
        SET 
            [DescripcionGenero] = CASE WHEN ISNULL(@DescripcionGenero,'')='' THEN [DescripcionGenero] ELSE @DescripcionGenero END
            ,[LargoGenero] = CASE WHEN ISNULL(@LargoGenero,-1)<0 THEN [LargoGenero] ELSE @LargoGenero END
            ,[TipoDatoGenero] = CASE WHEN ISNULL(@TipoDatoGenero,'')='' THEN [TipoDatoGenero] ELSE @TipoDatoGenero END
        WHERE [GeneroID] = @GeneroID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [GeneroID]
            ,[DescripcionGenero]
            ,[LargoGenero]
            ,[TipoDatoGenero]
        FROM [dbo].[GEN]
        WHERE   1=1
        AND     [GeneroID] = CASE WHEN ISNULL(@GeneroID ,'')='' THEN [GeneroID] ELSE @GeneroID END
        AND     [DescripcionGenero] = CASE WHEN ISNULL(@DescripcionGenero ,'')='' THEN [DescripcionGenero] ELSE @DescripcionGenero END
        AND     [TipoDatoGenero] = CASE WHEN ISNULL(@TipoDatoGenero,'')='' THEN [TipoDatoGenero] ELSE @TipoDatoGenero END
        AND     [LargoGenero] = CASE WHEN ISNULL(@LargoGenero,-1)<0 THEN [LargoGenero] ELSE @LargoGenero END
        ORDER BY [DescripcionGenero]
	END
END
GO
EXEC SPS_ABCS_GEN --@TABLA = 'GENERAL', @CAMPO = 'TIPONOVEDAD'




