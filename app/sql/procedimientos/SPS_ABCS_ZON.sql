IF OBJECT_ID('SPS_ABCS_ZON','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_ZON
GO
CREATE PROCEDURE DBO.SPS_ABCS_ZON
(
	@ACCION             VARCHAR(1) = 'S',
	@ZonaID             VARCHAR(2) = NULL,
    @DescripcionZona    VARCHAR(15) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[ZON]
           ([ZonaID]
           ,[DescripcionZona])
        SELECT @ZonaID, @DescripcionZona
        WHERE NOT EXISTS(SELECT * FROM [dbo].[ZON] WHERE ZonaID=@ZonaID )
        AND ISNULL(@ZonaID,'')<>'' 
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[ZON] WHERE [dbo].[ZON].[ZonaID] = @ZonaID
	END
	IF @ACCION = 'C'
	BEGIN
        UPDATE [dbo].[ZON]
        SET [DescripcionZona] = CASE WHEN ISNULL(@DescripcionZona,-1)<0 THEN [DescripcionZona] ELSE @DescripcionZona END
        WHERE [ZonaID] = @ZonaID 
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [ZonaID]
            ,[DescripcionZona]
        FROM [dbo].[ZON]
        WHERE   1=1
        AND     [ZonaID] = CASE WHEN ISNULL(@ZonaID ,'')='' THEN [ZonaID] ELSE @ZonaID END
        AND     [DescripcionZona] = CASE WHEN ISNULL(@DescripcionZona ,'')='' THEN [DescripcionZona] ELSE @DescripcionZona END
        ORDER BY [DescripcionZona]
	END
END
GO
EXEC SPS_ABCS_ZON 




