IF OBJECT_ID('SPS_ABCS_TGEN','P') IS NOT NULL DROP PROCEDURE SPS_ABCS_TGEN
GO
CREATE PROCEDURE DBO.SPS_ABCS_TGEN
(
	@ACCION         VARCHAR(1) = 'S',
	@TABLA          VARCHAR(15) = NULL,
	@CAMPO          VARCHAR(20) = NULL,
	@CODIGO         VARCHAR(20) = NULL,
	@DESCRIPCION    VARCHAR(256) = NULL,
	@VALOR1         DECIMAL(14, 2) = NULL,
	@DATO1          VARCHAR(255) = NULL,
	@DFECHA         TINYINT = NULL,
	@OPCIONESLIBRES TINYINT = NULL,
	@VALORINI       DECIMAL(14, 2) = NULL,
	@VALORFIN       DECIMAL(14, 2) = NULL,
	@VALOR2         DECIMAL(14, 2) = NULL,
	@DATO2          VARCHAR(255) = NULL
)
WITH ENCRYPTION
AS
BEGIN
	DECLARE @SQLString AS nvarchar(MAX)
	
	IF @ACCION = 'A'
	BEGIN
        INSERT INTO [dbo].[TGEN] ([TABLA], [CAMPO], [CODIGO], [DESCRIPCION], [VALOR1], [DATO1], [DFECHA], [OPCIONESLIBRES], [VALORINI], [VALORFIN], [VALOR2], [DATO2])
        SELECT @TABLA, @CAMPO, @CODIGO, @DESCRIPCION, @VALOR1, @DATO1, @DFECHA, @OPCIONESLIBRES, @VALORINI, @VALORFIN, @VALOR2, @DATO2
        WHERE NOT EXISTS(SELECT * FROM [dbo].[TGEN] WHERE TABLA=@TABLA AND CAMPO=@CAMPO AND CODIGO=@CODIGO)
        AND ISNULL(@TABLA,'')<>'' AND ISNULL(@CAMPO,'')<>'' AND ISNULL(@CODIGO,'')<>'' AND ISNULL(@DESCRIPCION,'')<>''
 	END 
	IF @ACCION = 'B'
	BEGIN
		DELETE FROM [dbo].[TGEN] WHERE [dbo].[TGEN].[TABLA] = @TABLA AND [dbo].[TGEN].[CAMPO]=@CAMPO AND [dbo].[TGEN].[CODIGO]=@CODIGO
	END
	IF @ACCION = 'C'
	BEGIN
		IF ISNULL(@TABLA,'')<>'' AND ISNULL(@CAMPO,'')<>'' AND ISNULL(@CODIGO,'')<>'' AND ISNULL(@DESCRIPCION,'')<>''
		BEGIN
			UPDATE [dbo].[TGEN]
            SET 
                [DESCRIPCION] = CASE WHEN ISNULL(@DESCRIPCION,'')='' THEN [DESCRIPCION] ELSE @DESCRIPCION END
                ,[VALOR1] = CASE WHEN ISNULL(@VALOR1,-1)<0 THEN [VALOR1] ELSE @VALOR1 END
                ,[DATO1] = CASE WHEN ISNULL(@DATO1,'')='' THEN [DATO1] ELSE @DATO1 END
                ,[DFECHA] = CASE WHEN ISNULL(@DFECHA,'')='' THEN [DFECHA] ELSE @DFECHA END
                ,[OPCIONESLIBRES] = CASE WHEN ISNULL(@OPCIONESLIBRES,'')='' THEN [OPCIONESLIBRES] ELSE @OPCIONESLIBRES END
                ,[VALORINI] = CASE WHEN ISNULL(@VALORINI,-1)<0 THEN [VALORINI] ELSE @VALORINI END
                ,[VALORFIN] = CASE WHEN ISNULL(@VALORFIN,-1)<0 THEN [VALORFIN] ELSE @VALORFIN END
                ,[VALOR2] = CASE WHEN ISNULL(@VALOR2,-1)<0 THEN [VALOR2] ELSE @VALOR2 END
                ,[DATO2] = CASE WHEN ISNULL(@DATO2,'')='' THEN [DATO2] ELSE @DATO2 END
            WHERE [TABLA] = @TABLA AND [CAMPO] = @CAMPO AND [CODIGO] = @CODIGO
		END
	END
	IF @ACCION = 'S'
	BEGIN
        SELECT [TABLA]
            ,[CAMPO]
            ,[CODIGO]
            ,[DESCRIPCION]
            ,[VALOR1]
            ,[DATO1]
            ,[DFECHA]
            ,[OPCIONESLIBRES]
            ,[VALORINI]
            ,[VALORFIN]
            ,[VALOR2]
            ,[DATO2]
        FROM [dbo].[TGEN]
        WHERE   1=1
        AND     [TABLA] = CASE WHEN ISNULL(@TABLA ,'')='' THEN [TABLA] ELSE @TABLA END
        AND     [CAMPO] = CASE WHEN ISNULL(@CAMPO ,'')='' THEN [CAMPO] ELSE @CAMPO END
        AND     [CODIGO] = CASE WHEN ISNULL(@CODIGO,'')='' THEN [CODIGO] ELSE @CODIGO END
        AND     [DESCRIPCION] = CASE WHEN ISNULL(@DESCRIPCION,'')='' THEN [DESCRIPCION] ELSE @DESCRIPCION END
        AND     ISNULL([VALOR1],0) = CASE WHEN ISNULL(@VALOR1,-1)<0 THEN ISNULL([VALOR1],0) ELSE @VALOR1 END
        AND     [DATO1] = CASE WHEN ISNULL(@DATO1,'')='' THEN [DATO1] ELSE @DATO1 END
        AND     [DFECHA] = CASE WHEN ISNULL(@DFECHA,'')='' THEN [DFECHA] ELSE @DFECHA END
        AND     [OPCIONESLIBRES] = CASE WHEN ISNULL(@OPCIONESLIBRES,'')='' THEN [OPCIONESLIBRES] ELSE @OPCIONESLIBRES END
        AND     [VALORINI] = CASE WHEN ISNULL(@VALORINI,-1)<0 THEN [VALORINI] ELSE @VALORINI END
        AND     [VALORFIN] = CASE WHEN ISNULL(@VALORFIN,-1)<0 THEN [VALORFIN] ELSE @VALORFIN END
        AND     ISNULL([VALOR2],0) = CASE WHEN ISNULL(@VALOR2,-1) < 0 THEN ISNULL([VALOR2],0) ELSE @VALOR2 END
        AND     [DATO2] = CASE WHEN ISNULL(@DATO2,'')='' THEN [DATO2] ELSE @DATO2 END
        ORDER BY TABLA,CAMPO,CODIGO
	END
END
GO
EXEC SPS_ABCS_TGEN --@TABLA = 'GENERAL', @CAMPO = 'TIPONOVEDAD'




