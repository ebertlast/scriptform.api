IF OBJECT_ID('SPS_CONSULTAR_TODAS_TABLAS','P') IS NOT NULL DROP PROCEDURE SPS_CONSULTAR_TODAS_TABLAS
GO
CREATE PROC SPS_CONSULTAR_TODAS_TABLAS
(
    @CadenaAConsultar nvarchar(100)
)
AS
BEGIN

    CREATE TABLE #Results (NombreColumna nvarchar(370), ValorColumna nvarchar(3630))

    SET NOCOUNT ON

    DECLARE @TableName nvarchar(256), @NombreColumna nvarchar(128), @CadenaAConsultar2 nvarchar(110)
    SET  @TableName = ''
    SET @CadenaAConsultar2 = QUOTENAME('%' + @CadenaAConsultar + '%','''')

    WHILE @TableName IS NOT NULL
    BEGIN
        SET @NombreColumna = ''
        SET @TableName = 
        (
            SELECT MIN(QUOTENAME(TABLE_SCHEMA) + '.' + QUOTENAME(TABLE_NAME))
            FROM 	INFORMATION_SCHEMA.TABLES
            WHERE 		TABLE_TYPE = 'BASE TABLE'
                AND	QUOTENAME(TABLE_SCHEMA) + '.' + QUOTENAME(TABLE_NAME) > @TableName
                AND	OBJECTPROPERTY(
                        OBJECT_ID(
                            QUOTENAME(TABLE_SCHEMA) + '.' + QUOTENAME(TABLE_NAME)
                             ), 'IsMSShipped'
                               ) = 0
        )

        WHILE (@TableName IS NOT NULL) AND (@NombreColumna IS NOT NULL)
        BEGIN
            SET @NombreColumna =
            (
                SELECT MIN(QUOTENAME(COLUMN_NAME))
                FROM 	INFORMATION_SCHEMA.COLUMNS
                WHERE 		TABLE_SCHEMA	= PARSENAME(@TableName, 2)
                    AND	TABLE_NAME	= PARSENAME(@TableName, 1)
                    AND	DATA_TYPE IN ('char', 'varchar', 'nchar', 'nvarchar')
                    AND	QUOTENAME(COLUMN_NAME) > @NombreColumna
            )

            IF @NombreColumna IS NOT NULL
            BEGIN
                INSERT INTO #Results
                EXEC
                (
                    'SELECT ''' + @TableName + '.' + @NombreColumna + ''', LEFT(' + @NombreColumna + ', 3630) 
                    FROM ' + @TableName + ' (NOLOCK) ' +
                    ' WHERE ' + @NombreColumna + ' LIKE ' + @CadenaAConsultar2
                )
            END
        END	
    END

    SELECT NombreColumna, ValorColumna FROM #Results
END
GO
--EXEC DBO.SPS_CONSULTAR_TODAS_TABLAS @CadenaAConsultar='COLECTIVA'
