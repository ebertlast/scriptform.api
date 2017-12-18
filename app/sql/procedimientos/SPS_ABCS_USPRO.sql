IF OBJECT_ID('SPS_ABCS_USPRO','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_USPRO
GO
CREATE PROCEDURE DBO.SPS_ABCS_USPRO
(
	@ACCION                     VARCHAR(1) = 'S',
	@ProcedimientoID            VARCHAR(30) = NULL,
    @DescripcionProcedimiento   VARCHAR(200) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[USPRO]([ProcedimientoID], [DescripcionProcedimiento])
        SELECT @ProcedimientoID, @DescripcionProcedimiento
        WHERE NOT EXISTS(SELECT * FROM [dbo].[USPRO] WHERE ProcedimientoID=@ProcedimientoID )
        AND ISNULL(@ProcedimientoID,'')<>'' AND ISNULL(@DescripcionProcedimiento,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[USPRO] WHERE [dbo].[USPRO].[ProcedimientoID] = @ProcedimientoID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[USPRO]
        SET 
            [DescripcionProcedimiento] = CASE WHEN ISNULL(@DescripcionProcedimiento,'')='' THEN [DescripcionProcedimiento] ELSE @DescripcionProcedimiento END
        WHERE [ProcedimientoID] = @ProcedimientoID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [ProcedimientoID]
            ,[DescripcionProcedimiento]
        FROM [dbo].[USPRO]
        WHERE   1=1
        AND     [ProcedimientoID] = CASE WHEN ISNULL(@ProcedimientoID ,'')='' THEN [ProcedimientoID] ELSE @ProcedimientoID END
        AND     [DescripcionProcedimiento] = CASE WHEN ISNULL(@DescripcionProcedimiento ,'')='' THEN [DescripcionProcedimiento] ELSE @DescripcionProcedimiento END
        ORDER BY [DescripcionProcedimiento]
	END
END
GO
EXEC SPS_ABCS_USPRO




