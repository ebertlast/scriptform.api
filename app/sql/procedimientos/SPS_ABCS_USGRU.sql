IF OBJECT_ID('SPS_ABCS_USGRU','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_USGRU
GO
CREATE PROCEDURE DBO.SPS_ABCS_USGRU
(
	@ACCION             VARCHAR(1) = 'S',
	@GrupoID            VARCHAR(30) = NULL,
    @DescripcionGrupo   VARCHAR(200) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[USGRU]([GrupoID], [DescripcionGrupo])
        SELECT @GrupoID, @DescripcionGrupo
        WHERE NOT EXISTS(SELECT * FROM [dbo].[USGRU] WHERE GrupoID=@GrupoID )
        AND ISNULL(@GrupoID,'')<>'' AND ISNULL(@DescripcionGrupo,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[USGRU] WHERE [dbo].[USGRU].[GrupoID] = @GrupoID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[USGRU]
        SET 
            [DescripcionGrupo] = CASE WHEN ISNULL(@DescripcionGrupo,'')='' THEN [DescripcionGrupo] ELSE @DescripcionGrupo END
        WHERE [GrupoID] = @GrupoID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [GrupoID]
            ,[DescripcionGrupo]
        FROM [dbo].[USGRU]
        WHERE   1=1
        AND     [GrupoID] = CASE WHEN ISNULL(@GrupoID ,'')='' THEN [GrupoID] ELSE @GrupoID END
        AND     [DescripcionGrupo] = CASE WHEN ISNULL(@DescripcionGrupo ,'')='' THEN [DescripcionGrupo] ELSE @DescripcionGrupo END
        ORDER BY [DescripcionGrupo]
	END
END
GO
EXEC SPS_ABCS_USGRU




