IF OBJECT_ID('SPS_ABCS_USPROH','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_USPROH
GO
CREATE PROCEDURE DBO.SPS_ABCS_USPROH
(
	@ACCION             VARCHAR(1) = 'S',
        @ProcedimientoID    VARCHAR(30) = NULL,
        @ControlID          VARCHAR(100) = NULL,
        @DescripcionControl VARCHAR(200) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
                INSERT INTO [dbo].[USPROH]([ProcedimientoID], [DescripcionControl], [ControlID])
                SELECT @ProcedimientoID, @DescripcionControl, @ControlID
                WHERE NOT EXISTS(SELECT * FROM [dbo].[USPROH] WHERE ProcedimientoID=@ProcedimientoID AND [ControlID]=@ControlID)
                AND ISNULL(@ProcedimientoID,'')<>'' AND ISNULL(@DescripcionControl,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[USPROH] 
                WHERE   [dbo].[USPROH].[ProcedimientoID] = @ProcedimientoID 
                AND     [dbo].[USPROH].[ControlID] = @ControlID
	END
	IF @ACCION = 'C'
	BEGIN
                UPDATE [dbo].[USPROH]
                SET     [DescripcionControl] = @DescripcionControl
                WHERE   [ProcedimientoID] = @ProcedimientoID
                AND     [ControlID] = @ControlID
	END
	IF @ACCION = 'S'
	BEGIN
                SELECT [ProcedimientoID]
                ,[ControlID]
                ,[DescripcionControl]
                FROM    [dbo].[USPROH]
                WHERE   [dbo].[USPROH].[ProcedimientoID] = CASE WHEN @ProcedimientoID  IS NULL THEN ProcedimientoID  ELSE @ProcedimientoID  END
                AND     [dbo].[USPROH].[DescripcionControl] = CASE WHEN @DescripcionControl IS NULL THEN DescripcionControl ELSE @DescripcionControl END
	END
END
GO
EXEC SPS_ABCS_USPROH




