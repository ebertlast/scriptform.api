-- Tamaño de empresas
IF OBJECT_ID('SPS_ABCS_TAE','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_TAE
GO
CREATE PROCEDURE DBO.SPS_ABCS_TAE
(
	@ACCION             VARCHAR(1) = 'S',
	@TamanoID           VARCHAR(2) = NULL,
    @DescripcionTamano  VARCHAR(30) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[TAE]
           ([TamanoID]
           ,[DescripcionTamano])
        SELECT @TamanoID, @DescripcionTamano
        WHERE NOT EXISTS(SELECT * FROM [dbo].[TAE] WHERE TamanoID=@TamanoID )
        AND ISNULL(@TamanoID,'')<>'' AND ISNULL(@DescripcionTamano,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[TAE] WHERE [dbo].[TAE].[TamanoID] = @TamanoID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[TAE]
        SET 
            [DescripcionTamano] = CASE WHEN ISNULL(@DescripcionTamano,'')='' THEN [DescripcionTamano] ELSE @DescripcionTamano END
        WHERE [TamanoID] = @TamanoID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [TamanoID]
            ,[DescripcionTamano]
        FROM [dbo].[TAE]
        WHERE   1=1
        AND     [TamanoID] = CASE WHEN ISNULL(@TamanoID ,'')='' THEN [TamanoID] ELSE @TamanoID END
        AND     [DescripcionTamano] = CASE WHEN ISNULL(@DescripcionTamano ,'')='' THEN [DescripcionTamano] ELSE @DescripcionTamano END
        ORDER BY [DescripcionTamano]
	END
END
GO
EXEC SPS_ABCS_TAE-- @TamanoID = '8'--, @CAMPO = 'TIPONOVEDAD'




