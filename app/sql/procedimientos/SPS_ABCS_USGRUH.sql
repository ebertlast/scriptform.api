IF OBJECT_ID('SPS_ABCS_USGRUH','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_USGRUH
GO
CREATE PROCEDURE DBO.SPS_ABCS_USGRUH
(
	@ACCION             VARCHAR(1) = 'S',
	@GrupoID            VARCHAR(30) = NULL,
    @ProcedimientoID    VARCHAR(30) = NULL,
    @ControlID          VARCHAR(100) = NULL,
    @Permiso            BIT = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        IF(SELECT COUNT(*) FROM USGRUH WHERE GrupoID=@GrupoID AND ProcedimientoID=@ProcedimientoID AND ControlID=@ControlID)>0
        BEGIN
            SET @ACCION='C'
        END
        ELSE
        BEGIN
            INSERT INTO [dbo].[USGRUH]([GrupoID], [ProcedimientoID], [ControlID], [Permiso])
            SELECT @GrupoID, @ProcedimientoID, @ControlID, ISNULL(@Permiso,0)
            WHERE ISNULL(@GrupoID,'')<>'' AND ISNULL(@ProcedimientoID,'')<>'' AND ISNULL(@ControlID,'')<>''
        END
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[USGRUH] 
        WHERE   [dbo].[USGRUH].[GrupoID] = @GrupoID 
        AND     [dbo].[USGRUH].[ProcedimientoID] = @ProcedimientoID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE  [dbo].[USGRUH]
        SET     [Permiso] = CASE WHEN @Permiso IS NULL THEN Permiso ELSE @Permiso END
        WHERE   [ProcedimientoID] = @ProcedimientoID
        AND     [GrupoID] = @GrupoID
        AND     [ControlID] = @ControlID

	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [GrupoID]
            ,[ProcedimientoID]
            ,[ControlID]
            ,[Permiso]
        FROM [dbo].[USGRUH]
        WHERE [ProcedimientoID] = CASE WHEN @ProcedimientoID IS NULL THEN ProcedimientoID ELSE @ProcedimientoID END
        AND     [GrupoID] = CASE WHEN @GrupoID IS NULL THEN GrupoID ELSE @GrupoID END
        AND     [ControlID] = CASE WHEN @ControlID IS NULL THEN ControlID ELSE @ControlID END
	END
END
GO
EXEC SPS_ABCS_USGRUH




